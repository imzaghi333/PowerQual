var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript"; 
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);
/*
window.onload = function(){
    function returnvalue(selectid,val){
        window.opener.document.getElementById("subject["+selectid+"]").value=val;
        window.close(this);
    }
}*/
// ----------- added on 2022-1-3 -----------
// 1.Defect Mode(Symptom)
function returnvalue1(selectid,val){
    window.opener.document.getElementById("subject1["+selectid+"]").value=val;
}
// 2.Defect Mode(Symptom+Finding)
function returnvalue2(selectid,val){
    window.opener.document.getElementById("subject2["+selectid+"]").value=val;
}
// 3.RCCA
function returnvalue3(selectid,val){
    window.opener.document.getElementById("subject3["+selectid+"]").value=val;
}
// 4.Issuestatus
function returnvalue4(selectid,val){
    window.opener.document.getElementById("subject4["+selectid+"]").value=val;
}
// 5.Category
function returnvalue5(selectid,val){
    window.opener.document.getElementById("subject5["+selectid+"]").value=val;
}
// 6.PIC
function returnvalue6(selectid,val){
    window.opener.document.getElementById("subject6["+selectid+"]").value=val;
}
// 7.JIRA
function returnvalue7(selectid,val){
    window.opener.document.getElementById("subject7["+selectid+"]").value=val;
}
// 8.SPR
function returnvalue8(selectid,val){
    window.opener.document.getElementById("subject8["+selectid+"]").value=val;
}
// 9.TEMP
function returnvalue9(selectid,val){
    window.opener.document.getElementById("subject9["+selectid+"]").value=val;
}
// 10.Dropcycles
function returnvalue10(selectid,val){
    window.opener.document.getElementById("subject10["+selectid+"]").value=val;
}
// 11.Drops
function returnvalue11(selectid,val){
    window.opener.document.getElementById("subject11["+selectid+"]").value=val;
}
// 12.Dropside
function returnvalue12(selectid,val){
    window.opener.document.getElementById("subject12["+selectid+"]").value=val;
}
// 13.HIT
function returnvalue13(selectid,val){
    window.opener.document.getElementById("subject13["+selectid+"]").value=val;
}
// 14.NextCheckpointDate
function returnvalue14(selectid,val){
    window.opener.document.getElementById("subject14["+selectid+"]").value=val;
}
// 15.IssuePublished
function returnvalue15(selectid,val){
    window.opener.document.getElementById("subject15["+selectid+"]").value=val;
}
// 16.ORTMFGDate
function returnvalue16(selectid,val){
    window.opener.document.getElementById("subject16["+selectid+"]").value=val;
}
// 17.ReportedDate
function returnvalue17(selectid,val){
    window.opener.document.getElementById("subject17["+selectid+"]").value=val;
}
// 18.change default result
function returnvalue18(selectid,val){
    window.opener.document.getElementById("subject18["+selectid+"]").value=val;
}
// added on 2022-02-17
// 19.Fail symptom
function returnvalue19(row_no,val){
    window.opener.document.getElementById("fail["+row_no+"]").value+=val+"\n";
}
// 20.RCCA
function returnvalue20(row_no,val){
    //alert("Row:"+row_no+" ,value:"+val);
    window.opener.document.getElementById("rcca["+row_no+"]").value+=val+"\n";
}

// ----------- added on 2022-04-20 -----------
function allPass(){
    var aBtn = document.getElementById("all_pass");
    alert(aBtn);
}