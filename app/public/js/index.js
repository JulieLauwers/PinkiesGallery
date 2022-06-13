window.onload = function () {
customElements.define(
    "ad-banner",
    class AdBanner extends HTMLElement {
      constructor() {
        super();
  
        
        this.attachShadow({ mode: "open" });

        const divBanner = document.createElement('div');
        
        divBanner.setAttribute("class", "div");

      const img = document.createElement("img");
      img.src = "/img/PalmboomMetZon.jpg";
  
      const divContent = document.createElement('div');
      divContent.setAttribute("class", "content");

        const titleBanner = document.createElement("h3");
       titleBanner.textContent = "Pinkie Photography";

        const textBanner = document.createElement("p");
        textBanner.textContent = "Hi I am Julie and I am a photographer, I make photos and upload them on my website for people to see what for photos I make. You can also ask me questions about hiring me.";

        const spanBanner = document.createElement("span");
        spanBanner.textContent = "Photo made by Julie Lauwers";

        const aLink = document.createElement("a");
        aLink.src = "#"
        
        const style = document.createElement("style");
        style.textContent = `
        .content {
          display: flex;
          flex-direction: column;
        }
          .div { 
            padding: 10px;
            margin: 10px; 
            display: flex; 
            flex-direction: row;
            border-radius: 5px; 
            border: 1px solid lightgray;
            padding: 10px;
            box-shadow: 10px 10px 8px 10px #d3cece;
        }
          img { height: 25rem; width: 40rem; }
          h3 {   margin: 10px 0 10px 10px; display: inline-block;}
          p  {   margin-bottom: 0.5rem; }
          span {color: lightgray; }
        `;

        divContent.append(img, titleBanner, textBanner, spanBanner, aLink);
        divBanner.append(divContent);
        this.shadowRoot.append(divBanner, style);

      }
    }
  );
}