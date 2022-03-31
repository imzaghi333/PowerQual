var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript"; 
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);

window.onload = function(){
    function returnvalue(selectid,val){
        window.opener.document.getElementById("subject["+selectid+"]").value=val;
        window.close(this);
    }
}

// ----------- added on 2022-1-3 -----------
function returnvalue1(selectid,val){
    window.opener.document.getElementById("subject1["+selectid+"]").value=val;
}

function returnvalue2(selectid,val){
    window.opener.document.getElementById("subject2["+selectid+"]").value=val;
}

function returnvalue3(selectid,val){
    window.opener.document.getElementById("subject3["+selectid+"]").value=val;
}

function returnvalue4(selectid,val){
    window.opener.document.getElementById("subject4["+selectid+"]").value=val;
}

function returnvalue5(selectid,val){
    window.opener.document.getElementById("subject5["+selectid+"]").value=val;
}

function returnvalue6(selectid,val){
    window.opener.document.getElementById("subject6["+selectid+"]").value=val;
}

function returnvalue7(selectid,val){
    window.opener.document.getElementById("subject7["+selectid+"]").value=val;
}

function returnvalue8(selectid,val){
    window.opener.document.getElementById("subject8["+selectid+"]").value=val;
}

function returnvalue9(selectid,val){
    window.opener.document.getElementById("subject9["+selectid+"]").value=val;
}

function returnvalue10(selectid,val){
    window.opener.document.getElementById("subject10["+selectid+"]").value=val;
}

function returnvalue11(selectid,val){
    window.opener.document.getElementById("subject11["+selectid+"]").value=val;
}

function returnvalue12(selectid,val){
    window.opener.document.getElementById("subject12["+selectid+"]").value=val;
}

function returnvalue13(selectid,val){
    window.opener.document.getElementById("subject13["+selectid+"]").value=val;
}

function returnvalue14(selectid,val){
    window.opener.document.getElementById("subject14["+selectid+"]").value=val;
}

function returnvalue15(selectid,val){
    window.opener.document.getElementById("subject15["+selectid+"]").value=val;
}

function returnvalue16(selectid,val){
    window.opener.document.getElementById("subject16["+selectid+"]").value=val;
}

function returnvalue17(selectid,val){
    window.opener.document.getElementById("subject17["+selectid+"]").value=val;
}

function returnvalue18(selectid,val){
    window.opener.document.getElementById("subject18["+selectid+"]").value=val;
}