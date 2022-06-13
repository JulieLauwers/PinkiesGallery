window.onload = function () {
customElements.define(
    "adbanner",
    class extends HTMLElement {
      constructor() {
        super();
  
        
        const shadow = this.attachShadow({ mode: "open" });

        const divBanner = document.createElement("div");
  
        /*
        let imgUrl;
        if (this.hasAttribute("img")) {
          imgUrl = this.getAttribute("img");
        } else {
          imgUrl = "img/default.png";
        }*/
    

      const img = document.createElement("img");
        img.src = "/img/PalmboomMetZon.jpg";
  
        const titleBanner = document.createElement("h3");
        titleAboutPhoto.textContent = "Pinkie Photography";

        //const textBanner = document.createElement("p");
        //textBanner.textContent = "Hi I am Julie and I am a photographer, I make photos and upload them on my website for people to see what for photos I make. You can also ask me questions about hiring me.";

        //const spanBanner = document.createElement("span");
        //spanBanner.textContent = "Photo made by Julie Lauwers";

        //const aLink = document.createElement("a");
        //aLink.src = "#"
        
        const style = document.createElement("style");
        style.textContent = `
          div { 
            padding: 10px;
            margin: 10px; 
            display: flex; 
            border-radius: 5px; 
            border: 1px solid lightgray;
            padding: 10px;
            box-shadow: 10px 10px 8px 10px #d3cece;
        }
          img { height: 32rem; width: 40rem; }
          h3 { margin: 10px 0 10px 10px; }
          p  {margin-bottom: 0.5rem; }
          span { color: lightgray; }
        `;
  
        shadow.append(divBanner, style);
  
        divBanner.append(img, titleBanner/*, textBanner/*, spanBanner, aLink*/);
      }
    }
  );

  customElements.define(
    "custom-element",
    class extends HTMLElement {
      //2: Maak de constructor aan hier gaat de code voor het custom component komen
  
      constructor() {
        //3: Eerst en vooral zetten we super() in de constructor dit is zeer belanrijk!
        super();
        //4: Nu gaan we beginnen coderen, we beginnen mede de shadow mode op open te zetten (tip: attachShadow)
        const shadow = this.attachShadow({mode: "open"});
        //5: Maak een div aan met behand van “createElement”
        const div = document.createElement("div");
        //6: Maak k nu op dezelfde manier een paragraaf aan (<p>)
        const p = document.createElement("p");
        //7: Zet de “textContent” van de paragraaf op “dit is een custom element”
        p.textContent= "Dit is een custom element";
        //8: Styling toevoegen met “createElement” en <style> tag
        const style = document.createElement("style");
        //9: Het style element styling geven aan de hand van “textContent”
        style.textContent = `
          div { padding: 10px; border: 1px solid gray; margin: 10px; display: flex; }
          p { margin: 10px 0; }
        `;
        //10: Nu moet je de div(hoofdelement) en style aan de shadow binden gebruik ‘append’
        shadow.append(div, style);
        //11: De p moet gebind worden aan de div dit doe je ook met ‘append’
        div.append(p);
      }
    }
  );
}