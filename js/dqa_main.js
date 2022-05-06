/* ----------- import jQuery ---------- */
var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript";
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);

window.onload = function(){
    // ------- 首頁結果欄位上的提示 -------
    var items1 = document.getElementsByClassName("items1");
    var qr_tips = document.getElementsByClassName("qr_tip");
    for(var i=0; i<items1.length; i++){
        items1[i].index = i;    //自定义一个index
        items1[i].onmouseover = function(){
            for(var i=0; i<qr_tips.length; i++){
                qr_tips[this.index].style.display = "inline";
            }
        }
        items1[i].onmouseout = function(){
            for(var i=0; i<qr_tips.length; i++){
                qr_tips[i].style.display = "none";
            }
        }
    }
    // ----------- logo变换 ----------
    var logo = document.getElementById("logo");
    //alert(logo.src);
    logo.onmouseover = function(){
        logo.src = "images/qian-weichat.png"
    }
    logo.onmouseout = function(){
        logo.src = "images/logo.svg";
    }
    // ----------- Details -----------
    var oDiv=document.getElementById("wrapper");
    var aBtn=oDiv.getElementsByTagName("button");
	var aDiv=oDiv.getElementsByTagName("div");
    for(var i=0;i<aBtn.length;i++){
	    aBtn[i].index=i;
	    aBtn[i].onclick=function(){
            for(var i=0;i<aBtn.length;i++){
                aBtn[i].className='inactive';
                aDiv[i].style.display='none';
            }
            this.className='active';
            aDiv[this.index].style.display='block';
        }
	}
}

// -------------------------- functions ------------------------------------------------

function checkForm1(){
    if(document.form1.ym.value.length == 0){
        layer.msg("請選擇年月！~~~",{icon: 2});
        return false;
    }
    else if(document.form1.unit.value.length == 0){
        layer.msg("請輸入數量(如：1,2,3...)！~~~",{icon: 2});
        return false;
    }
    else if(!/\d{1,}/.test(document.form1.unit.value)){
        layer.msg("輸入的不是數字:(",{icon: 2});
        return false;
    }
    else if(document.form1.tester.value.length == 0){
        layer.msg("請輸入測試人(如：Donald Trump)！~~~",{icon: 2});
        return false;
    }
    else if(!/[a-zA-Z\s]{2,30}/.test(document.form1.tester.value)){
        layer.msg("英文名有误！~~~",{icon: 2});
        return false;
    }
    else if(!/[^\u4E00-\u9FA5]/.test(document.form1.tester.value)){
        layer.msg("請輸入英文名！~~~",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}

function checkFormUpload(){
    if(document.upload.dropbox.value == ""){
        layer.msg("請選取需要更新的Dropbox",{icon: 2});
        return false;
    }
    if(document.upload.myfile.value == ""){
        layer.msg("請選取需要上傳的Excel",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}


function checkSerch(){
    if(document.search.search.value.length == 0){
        layer.msg("輸入搜索内容:(",{icon: 2});
        return false;
    }
    return true;
}

function checkAddDropbox(){
    if(document.add_dropbox.dropbox.value == ""){
        layer.msg("請選取需要更新的Dropbox",{icon: 2});
        return false;
    }
    else if(document.add_dropbox.added_txt.value == ""){
        layer.msg("請填寫Dropbox內容",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}

function checkDelDropbox(){
    if(document.del_dropbox.dropbox.value == ""){
        layer.msg("請選取需要更新的Dropbox",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}

function checkForm2(){
    if(document.form2.tb_name.value == ""){
        layer.msg("數據表名沒有傳遞！",{icon: 2});
        return false;
    }
    else if(document.form2.seg_name.value == ""){
        layer.msg("字段名沒有傳遞！",{icon: 2});
        return false;
    }
    else if(document.fom2.cc_id.value == ""){
        layer.msg("ID沒有傳遞！",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}

function checkForm3(){
    if(document.form3.opt_txt.value == ""){
        layer.msg("請填寫更新的內容！",{icon: 2});
        return false;
    }
    else if(document.form3.table.value == ""){
        layer.msg("數據表名沒有傳遞！",{icon: 2});
        return false
    }
    else if(document.form3.segment.value == ""){
        layer.msg("字段名沒有傳遞！",{icon: 2});
        return false;
    }
    else if(document.form3.id.value == ""){
        layer.msg("ID沒有傳遞！",{icon: 2});
        return false;
    }
    else{
        return true;
    }
}

function checkForm7(){
    var tester = document.form7.tester;
    var product = document.form7.product;
    var tt = document.form7.starting;
    if(tester.value=="" && product.value=="" && tt.value==""){
        layer.msg("總得選個查詢條件吧!~~~",{icon: 5});
        return false;
    }
    else{
        return true;
    }
}

function doubleNum(num){
    if(num<10){
        return "0"+num;
    }else{
        return num;
    }
}

function printResult(value){
    var result = document.getElementById("result");
    var index = result.selectedIndex;
    var txt = result.options[index].value;
    var reg = RegExp(/Fail/);
    if(txt.match(reg)){
        window.open("fail_one.php?id="+value,"_blank","填写Fail的原因","height=500, width=700, top=100, left=100");
    }
}

function confirmDel(id){
    if(window.confirm("您確定刪除嗎？")){
        location.href="./comm/delete.php?id="+id
    }
}

function deleteMatrix(username,product,starting){
    //alert(username+"==="+product+"==="+starting);
    if(window.confirm("您確定刪除嗎?")){
        location.href="./comm/delete.php?username="+username+"&product="+product+"&starting="+starting;
    }
}