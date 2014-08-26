function validateForm() {
    
    var send_form_data = true;
    
    // get form data
    var winename = document.getElementById("txtwinename").value;
    var wineryname = document.getElementById("txtwineryname").value;
    var minnumberstock = document.getElementById("txtminwinestock").value;
    var minwineorder = document.getElementById("txtminwinesordered").value;
    var mindollarcost = document.getElementById("txtmincost").value;
    var maxdollarcost = document.getElementById("txtmaxcost").value;
    var region = $("#cboregion>option:selected").html()
    var grapevariety = $("#cbograpevariety>option:selected").html()
    var minrangeofyear = $("#cbominrangeofyear>option:selected").html()
    var maxrangeofyear = $("#cbomaxrangeofyear>option:selected").html()
    
    if (winename == null || winename == "") {
        send_form_data = false;
    }
    if (wineryname == null || wineryname == "") {
        send_form_data = false;
    }
    if (isNumber(minnumberstock) == false || minnumberstock == "") {
        send_form_data = false;
    }
    if (isNumber(minwineorder) == false || minwineorder == "") {
        send_form_data = false;
    }
    else if (isNumber(mindollarcost) == false || mindollarcost == "") {
        send_form_data = false;
    }
    if (isNumber(maxdollarcost) == false || maxdollarcost == "") {
        send_form_data = false;
    }
    if (region == null || region == "") {
        send_form_data = false;
    }
    if (grapevariety == null || grapevariety == "") {
        send_form_data = false;
    }
    if (mindollarcost == "" || mindollarcost == null) {
        send_form_data = false;
    }
    if (maxdollarcost == "" || maxdollarcost == null) {
        send_form_data = false;
    }
    if (Number(mindollarcost) > Number(maxdollarcost)) {
        send_form_data = false;
    }
    if (Number(maxdollarcost) < Number(mindollarcost)) {
        send_form_data = false;
    }
    if (minrangeofyear > maxrangeofyear) {
        send_form_data = false;
    }
    if (maxrangeofyear < minrangeofyear) {
        send_form_data = false;
    }
    
    if (send_form_data == true) {
        return send_form_data;
    }
    else {
        document.getElementById('lblerrordescription').style.display = 'block';
        setTimeout(function() {
            setTimeout(fade_out, 5000);
          }, 5000);
        return send_form_data;
    }
}

function fade_out() {
    document.getElementById('lblerrordescription').style.display = 'none';
}

function isNumber(n) {
    return /^-?(0|[1-9]\d*|(?=\.))(\.\d+)?$/.test(n);
}