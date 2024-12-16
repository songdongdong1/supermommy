window.interdeal = {
    "sitekey": "8a17330be8b23dc3dab740563ff1decc",
    "Position": "Left",
    "Menulang": "EN",
    "domains": {
        "js": "https://cdn.equalweb.com/",
        "acc": "https://access.equalweb.com/"
    },
    "btnStyle": {
        "vPosition": [
            "80%",
            null
        ],
        "scale": [
            "0.8",
            "0.8"
        ],
        "icon": {
            "type": 7,
            "shape": "semicircle"
        }
    }
};
(function(doc, head, body){
	var coreCall             = doc.createElement('script');
	coreCall.src             = 'https://cdn.equalweb.com/core/4.3.2/accessibility.js';
	coreCall.defer           = true;
	coreCall.integrity       = 'sha512-73oZhkzO+7F1r8AXT5BtChHyVvx8GMuB3Pokx6jdnP5Lw7xyBUO4L5KKi7BwqovhoqOWjNmkah1iCiMniyt6Kw==';
	coreCall.crossOrigin     = 'anonymous';
	coreCall.setAttribute('data-cfasync', true );
	body? body.appendChild(coreCall) : head.appendChild(coreCall);
})(document, document.head, document.body);