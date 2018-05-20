var http = {

    request: function () {
        return new XMLHttpRequest()
    },

    jsonToFormUrlEncoded: function (srcjson) {
        if(typeof srcjson !== "object")
            if(typeof console !== "undefined"){
                console.log("\"srcjson\" is not a JSON object");
                return null;
            }
        u = encodeURIComponent;
        var urljson = "";
        var keys = Object.keys(srcjson);
        for(var i=0; i <keys.length; i++){
            urljson += u(keys[i]) + "=" + u(srcjson[keys[i]]);
            if(i < (keys.length-1))urljson+="&";
        }
        return urljson;
    },

    isObjectEmpty: function (obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    },

    get: function (url, params, success, error) {
        if (!this.isObjectEmpty(params)) {
            url = url+"?"+this.jsonToFormUrlEncoded(params);
        }

        var req = new XMLHttpRequest();

        req.open("GET", url, true);
        req.send();

        if (req.readyState == 4 && req.status == 200) {
            req.onreadystatechange = success.bind(this, req.responseText);
        } else {
            req.onreadystatechange = error.bind(this, req.responseText, req.status);
        }
    },

    post: function (url, params, callback) {
        var body = this.jsonToFormUrlEncoded(params);

        this.ajax.open("POST", url, true);
        this.ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        this.ajax.send(body);
        this.ajax.onreadystatechange = callback;
    }
}