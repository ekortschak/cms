/*

Fader-Framework zum Einrichten von Bilderwechseln

*/

var FaderFramework = {

	// "Einstellungen"
	className: "fader",		// die Klasse, die unser Element trägt, in dem die Bilder sitzen sollen

	// Voreinstellungen für einen Fader
	viewTime: 5000,			// Zeit, die ein Bild angezeigt wird (in Millisekunden)
	fadeStep: 0.5,			// Prozent-Schritt beim Überblenden
	random: false,			// Zufällige Reihenfolge der Bilder (true|false)
	autostart: true,		// sofort mit dem Fading starten (true|false)

	// automatische Einstellungen
	baseURL: "",			// hier steht später der Pfad zum Verzeichnis, in dem sich dieses Script befindet.
	oldWinOnLoad: null,		// hier steht später vielleicht eine abgespeicherte Funktion
	inits: new Array(),		// hier stehen später auszuführende Initialisierungen
	faders: new Object(),	// hier werden die Fader stehen


	// Initialisier-Funktion - startet das FaderFramework (wird noch während des Ladens der Seite ausgeführt)
	start: function () {
		this.oldWinOnLoad = window.onload; // alte onload-Funktion abspeichern (falls vorhanden)

		// neue (anonyme!) onload-Funktion erstellen um eventuelle alte Funktion(en) zu kapseln
		window.onload = function () {
			// War bereits eine Funktion in window.onload abgelegt worden?
			if (typeof(FaderFramework.oldWinOnLoad) == "function") {
				// hier kann man nicht "this" benutzen, da diese Funktion nicht zu einem größeren Objekt gehört!
				FaderFramework.oldWinOnLoad(); // gespeicherte onload-Funktion ausführen
			}

			FaderFramework.onload(); // unsere onload-Funktion ausführen
		};
	},


	// onload-Funktion wird unmittelbar nach dem vollständigen Laden des Dokuments ausgeführt
	onload: function () {
		/* "this" verweist auf unser FaderFramework-Objekt! */

		var i, fader, css, scripts = document.getElementsByTagName("script");

		// baseURL herausfinden, um weitere Komponenten dieses Scripts nachladen zu können
		for (i = 0; i < scripts.length; i++) {
			if (scripts[i].src && scripts[i].src.match(/fader-framework\.js/)) {
				this.baseURL = scripts[i].src.replace(/(^|\/)fader-framework\.js$/, "");
			}
		}

		// weitere Komponenten einbinden wenn baseURL ermittelt wurde
		if (this.baseURL) {
			// unsere CSS-Datei einbinden (also <link rel="stylesheet" type="text/css" href="..." /> erzeugen)
			css = document.createElement("link");
			css.rel = "stylesheet";
			css.type = "text/css";
			css.href = this.baseURL + "/fader-framework.css";
			// <link />-Element im <head> hinten anfügen
			document.getElementsByTagName("head")[0].appendChild(css);
		}

		// vorgemerkte Fader erstellen
		fader = this.inits;
		delete this.inits; // wenn this.inits nicht existiert, dann erstellt this.init() echte Fader, anstatt sie nur vorzumerken

		for (i = 0; i < fader.length; i++) {
			this.init(fader[i]);
		}
	},


	// Funktion zum Einrichten eines Faders (wird noch während des Ladens der Seite ausgeführt - eventuell mehrmals)
	init: function (einstellungen) {
		/* "einstellungen" ist ein Objekt, das folgende Struktur haben muss:
			{
				id: "id-des-HTML-Elements",				   // muss einmalig sein!!
				images: ["pfad/bild1.jpg", "pfad/bild2.jpg"], // weitere Bilder möglich
				// optionale Angaben
				viewTime: 20000,
				fadeStep: 1,
				random: true,
				autostart: false
			}
		*/

		var fader;

		if (this.inits) {
			this.inits[this.inits.length] = einstellungen; // für später abspeichern

		} else {
			fader = new this.Fader(einstellungen); // this.Fader ist eine Konstruktor-Funktion!

			// abspeichern wenn Fader erfolgreich erstellt wurde
			if (fader != false && !this.faders[einstellungen.id]) {
				this.faders[fader.id] = fader;

				if (fader.autostart) {
					// Fader autostarten
					window.setTimeout(function () {	fader.start(); }, fader.viewTime); // start() wird dem Fader in der Konstruktor-Funktion verliehen, ebenso viewTime
				}
			}
		}
	},


	// Konstruktor:  Bauplan eines Faders
	Fader: function (einstellungen) {
	/*
		In diesem Konstruktor verweist "this" immer auf das zu erzeugende Objekt - vorausgesetzt,
		dieser Konstruktor wird mit dem Schlüsselwort "new" aufgerufen, z.B. var a = new this.Fader()
	*/

		// Darf eventuell kein Fader eingerichtet werden?
		if (
			// keine ID (oder ein Leerstring) übergeben
			!einstellungen.id
			||
			// kein HTML-Element mit dieser ID vorhanden
			!document.getElementById(einstellungen.id)
			||
			// für diese ID ist bereits ein Fader eingerichtet
			FaderFramework.faders[einstellungen.id]
			||
			// weniger als zwei Bilder angegeben
			einstellungen.images.length < 2
		) {
			// also gibt es keinen Fader für diesen init-Aufruf
			return new Boolean(false);
		}

		// Einstellungen des Faders vornehmen - wie "einstellungen" aussehen muss, siehe Funktion "init"!
		this.id = einstellungen.id;
		this.images = new Array(); // Bilder werden hier nicht als Zeichenketten, sondern später als HTML-Elementobjekte abgelegt...
		this.random = (typeof einstellungen.random != "undefined") ? einstellungen.random : FaderFramework.random;
		this.autostart = (typeof einstellungen.autostart != "undefined") ? einstellungen.autostart : FaderFramework.autostart;
		this.viewTime = einstellungen.viewTime || FaderFramework.viewTime;
		this.fadeStep = einstellungen.fadeStep || FaderFramework.fadeStep;
		this.stopped = false; // hiermit kann später der Fader angehalten werden
		this.playList = new Array(); // Wiedergabeliste
		this.counter = 0; // aktuell angezeigtes Bild (Zähler für Playlist)
		this.dir = ""; // Richtung - "backwards" führt zu umgekehrter Reihenfolge
		this.fading = false; // blockt die Funktion next, um Störungen beim Überblenden zu verhindern


		// <span>-Element als Container erzeugen und mit der Fader-Klasse ausrüsten
		this.element = document.createElement("span");
		this.element.className = FaderFramework.className;

		// Opera korrigieren
		if (window.opera) {
			this.element.style.display = "inline-table";
		}

		// das ursprüngliche Bild ersetzen
		var i;
		i = document.getElementById(this.id); // ursprüngliches Bild
		i.parentNode.replaceChild(this.element, i);

		// Bilder aus der Liste zu echten Bildobjekten machen und ins <span>-Element einhängen
		for (i = 0; i < einstellungen.images.length; i++) {
			this.images[i] = document.createElement("img");
			this.images[i].src = einstellungen.images[i];
			this.images[i].alt = "";

			// nur erstes Bild ins Dokument Einhängen
			if (i == 0) {
				this.element.appendChild(this.images[i]);
			}
		}


		/*
			Funktionen (Methoden) des Faders definieren!
		*/


		// Playlist generieren (enthält nur die Nummern der Bilder)
		this.createPlayList = function () {
			var i, r;

			this.playList = new Array();

			if (this.random) {
				// zufällige Reihenfolge
				while (this.playList.length < this.images.length) {
					vorhanden = false; // Zufallszahl bereits vorhanden?
					r = Math.floor(Math.random() * (this.images.length));
					for (i = 0; i < this.playList.length; i++) {
						if (r == this.playList[i]) {
							vorhanden = true;
						}
					}

					if (!vorhanden) {
						this.playList[this.playList.length] = r;
					}
				}

			} else {
				// geordnete Reihenfolge
				for (i = 0; i < this.images.length; i++) {
					this.playList[i] = i;
				}
			}
		};


		// Funktion zum Starten des Faders
		this.start = function () {
			this.stopped = false;
			this.next();
		};

		// Funktion zum Stoppen des Faders
		this.stop = function () {
			this.stopped = true; // verhindert, dass weitere window.setTimeout-Funktionen gestartet werden
		};


		// Funktion zum Anzeigen des nächsten Bildes
		this.next = function (single, dir) {
			// "single" ist true oder false und dient dazu, einen einmaligen Wechsel zu ermöglichen, ohne eine Slideshow zu starten. Wird kein Parameter übergeben, dann wird single nicht als true interpretiert.
			if (single) {
				this.stopped = true;
			}

			// Richtungsänderung übernehmen
			if (typeof dir == "string") {
				this.dir = dir;
			}

			// wurde der Fader angehalten?
			if ((this.stopped && !single) || this.fading) {
				return; // Ja -> keinen Bildwechsel durchführen!
			}

			// Counter weiterzählen (oder zurücksetzen)
			if (this.dir != "backwards") {
				this.counter = (this.counter < this.playList.length -1) ? this.counter +1 : 0;
				// Neue Playlist fällig?
				if  (this.counter == 0) {
					// neue Playlist generieren
					this.createPlayList(); // neue Playlist erstellen
				}
			} else {
				this.counter = (this.counter > 0) ? this.counter -1 : this.playList.length -1;
				// Neue Playlist fällig?
				if  (this.counter == this.playList.length -1) {
					// neue Playlist generieren
					this.createPlayList(); // neue Playlist erstellen
				}
			}


			// neues Bild zum Überblenden ins Element einhängen
			this.element.appendChild(this.images[this.playList[this.counter]]);
			this.images[this.playList[this.counter]].className = "next";

			// Fading einleiten
			this.fade();
		};

		// Fade-Funktion für den Bilderwechsel (jeder Aufruf entspricht einem Fading-Schritt)
		this.fade = function (step) {
			var fader = this, imgs = this.element.getElementsByTagName("img");

			// Bilderwechsel sperren, um Störungen während des Überblendens verhindern
			this.fading = true;

			// Wenn kein Wert übertragen wurde, dann muss das Fading von vorne durchgeführt werden
			step = step || 0;

			// neues Bild überblenden
			imgs[1].style.opacity = step/100;
			imgs[1].style.filter = "alpha(opacity=" + step + ")"; // IE?

			step += this.fadeStep;

			if (step <= 100) {
				window.setTimeout(function () { fader.fade(step); }, 1);
			} else {
				// Bilderwechsel wieder freischalten
				this.fading = false;

				// neues Bild ent-positionieren
				imgs[1].className = "";
				// altes Bild entfernen
				this.element.removeChild(imgs[0]);
				// Bildübergang abgeschlossen -> nach der Pause nächstes Bild
				window.setTimeout(function () { fader.next(); }, this.viewTime);
			}
		};

		// Fader initialisieren
		this.createPlayList();
	// fertigen Fader zurückgeben
	}
}

FaderFramework.start();
