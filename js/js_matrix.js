var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var units_qty =""// document.getElementById("units_qty");
var counts = ""//units_qty.value;
var gg = ""    //用于保存option group的字符串
var tt = ""    //用于保存option test item的字符串
var arrayclass=Array();


function groupchange(aa)
{
    //alert("aa="+aa);
        //var member_id = this.value;
        var el = document.getElementById("group"+aa).value;
        //alert(el.slice(6,7));
        var check=0;
        var test_item = document.getElementById("test_item"+aa);
        var test_item_opt = test_item.options;
        //$test_item.find("option").hide();
        //$set=test_item.find('option.'+el.val());
        //$set.show().first.prop('selectes',true);
        //var test_item_opt_class = test_item_opt[0].getAttribute('class');
        // alert(test_item_opt_class);
        //$("#test_item").empty();

        if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) 
        {
           // alert("Browser is Safari");  
            var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
           // alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
            if(nodesSnapshot.snapshotLength==57)
            {
                for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    var nodeclass=nodeA.getAttribute('class');
                    arrayclass.push(nodeclass);
                }  
            }
            var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/div", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
           // alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
            for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                var nodeA = nodesSnapshot.snapshotItem(i);
                //alert(arrayclass[i]);
                var elemA = document.createElement('option');
                elemA.innerHTML = nodeA.innerHTML;
                nodeA.parentNode.replaceChild(elemA, nodeA);
            }  

            var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
            //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
            for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                var nodeA = nodesSnapshot.snapshotItem(i);
                //alert(arrayclass[i]);
                var elemA = document.createElement('option');
                elemA.setAttribute("class",arrayclass[i])
                elemA.innerHTML = nodeA.innerHTML;
                nodeA.parentNode.replaceChild(elemA, nodeA);
            }  

            var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/option[@class!='"+el.slice(6,7)+"']", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
            //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
            for (var i = 1; i < nodesSnapshot.snapshotLength; i++) {
                var nodeA = nodesSnapshot.snapshotItem(i);
                var elemA = document.createElement('div');
                elemA.innerHTML = nodeA.innerHTML;
                nodeA.parentNode.replaceChild(elemA, nodeA);
            }       
        }
        
        for(var i=0; i<test_item_opt.length; i++){
            
            //alert("class="+test_item_opt[i].getAttribute('class'));
            if(test_item_opt[i].getAttribute('class')!=el.slice(6,7))
            {
                test_item_opt[i].setAttribute("hidden",true);
            }
            else
            {
                if(check==0)
                {
                    document.getElementById("test_item"+aa).options[i].selected="selected"
                }
                //alert("nothide");
                test_item_opt[i].removeAttribute("hidden");
                check=1;
            }
            if(check==0)
            {
                document.getElementById("test_item"+aa).options[0].selected="selected"

            }
        }

}

function innero(couts){
    // couts=Number(couts)+1;

    
     var rowCount=0;
     var table = document.getElementById("customers");
     var rows = table.getElementsByTagName("tr")
     //alert("rows.length="+rows.length);
     for (var i = 0; i < rows.length; i++) {
         if (rows[i].getElementsByTagName("td").length > 0) {
             ////alert(rows[i].getElementsByTagName("td").length);
             rowCount=rowCount+1;
         }
     }

     //alert("couts="+couts+"/rowCount="+rowCount);

     if(couts<rowCount)
     {
         //for(var u=couts;couts<rowCount;couts++){
         //   for (var d = 1; d <(Number(counts)+1); d++)
        //    {
            // alert("clean original_select")
            // alert(eval("original_select"+(couts+1)+d));
         //       eval("original_select"+(u+2)+d+"=original_select"+(u+1)+d);
         //       eval("original_select"+(u+1)+d+"=''");
         //   }
        //}

        for (var i = (rowCount); i > (couts); i--)
        {

            for (var d = 1; d <(Number(counts)+1); d++)
            {
  
                //alert("counts+1="+(Number(counts)+1));
               // alert("i="+i+"/ d= "+d);
              // alert(eval("original_select"+(i+1)+d));

               eval("original_select"+(i+1)+d+"=original_select"+(i)+d);
               eval("original_select"+(i)+d+"=''");
                
                document.getElementById("test_order"+(i)+d).setAttribute("id","test_order"+(i+1)+d);
                
                document.getElementById("test_order"+(i+1)+d).setAttribute("onchange","testchange("+(i+1)+","+d+")");

                

                ////var orse=eval("original_select"+(i+1)+d);
                //alert(orse);
                //if(orse!="")
                //{
                    
                  //  eval("original select"+(i+1)+d)=orse;
                   // eval("original select"+i+d)="";
                //}
                
                
            }
            
            document.getElementById("group"+(i)).setAttribute("id","group"+(i+1));
            document.getElementById("group"+(i+1)).setAttribute("onchange","groupchange("+(i+1)+")");
            document.getElementById("test_item"+(i)).setAttribute("id","test_item"+(i+1));
            document.getElementById((i)+"add").setAttribute("id",(i+1)+"add");                    
            document.getElementById((i)+"del").setAttribute("id",(i+1)+"del");
            document.getElementById((i+1)+"add").setAttribute("name",(i+1)+"add");
            document.getElementById((i+1)+"del").setAttribute("name",(i+1)+"del");

            
        }
    }


     
     var gp="";
     gp+='<select name="group[]" id="group'+(couts+1)+'" onchange="groupchange('+(couts+1)+')">';
     gp+=gg;
     gp+='</select>';
    // alert(gp);
     var ti="";
     //var to="";
     var bu="";
     ti+='<select name="test_item[]" class="selbox" id="test_item'+(couts+1)+'">';
     ti+=tt;
     ti+='</select>';

     //alert("couts="+couts+"/rowCount="+rowCount);


     var table = document.getElementById("customers");

     var row = table.insertRow(couts+1);
     var cell1 = row.insertCell(0);
     var cell2 = row.insertCell(1);
     cell1.innerHTML = gp;
     cell2.innerHTML = ti;
     
   // alert(couts);

     for(var ii=1; ii<(Number(counts)+1); ii++){
         var to="";
         to+='<select class="test_order" name="test_order[]" id="test_order'+(couts+1)+ii+'" onchange="testchange('+(couts+1)+','+ii+')">';
         to+=this["oo"+ii] ;
         to+='</select>';

         row.insertCell(ii+1).innerHTML=to;
         
     }
     
     var rowCount=0;
     var table = document.getElementById("customers");
     var rows = table.getElementsByTagName("tr")
     //alert("rows.length="+rows.length);
     for (var i = 0; i < rows.length; i++) {
         if (rows[i].getElementsByTagName("td").length > 0) {
             ////alert(rows[i].getElementsByTagName("td").length);
             rowCount=rowCount+1;
         }
     }
     
    // alert("innero couts="+couts);

     bu+='<input type="button" id="'+(couts+1)+'add"  name="'+(couts+1)+'add" class="btn_add" value="Add"/>&nbsp;&nbsp;<input type="button" id="'+(couts+1)+'del" name="'+(couts+1)+'del"  class="btn_del" value="Del" />'
     row.insertCell(ii+1).innerHTML=bu;

    

     //alert("rowCount="+rowCount+"couts-1="+(couts-1));

     $(':button[name='+(couts+1)+'add]').click(function(){
         //if(coutI==couts){
             //coutI += 1;
             var rowJavascript = this.parentNode.parentNode;
             var rowjQuery = $(this).closest("tr");
            // alert("JavaScript Row Index : " + (rowJavascript.rowIndex ) );
            // alert("button's couts+1="+(couts+1));
             var rowCount2=0;
             var table = document.getElementById("customers");
             var rows = table.getElementsByTagName("tr")
             //alert("rows.length="+rows.length);
             for (var i = 0; i < rows.length; i++) {
                 if (rows[i].getElementsByTagName("td").length > 0) {
                     ////alert(rows[i].getElementsByTagName("td").length);
                     rowCount2=rowCount2+1;
                 }
             }
             //alert("rowCount="+rowCount2);
             //addTr(rowCount2);
             innero(rowJavascript.rowIndex);
             
            
        // }
     })
     
     $(':button[name='+(couts+1)+'del]').click(function(){
         //coutI = coutI-1;
         var rowJavascript = this.parentNode.parentNode;
         var rowjQuery = $(this).closest("tr");
         couts=rowJavascript.rowIndex;
         //alert("couts="+(couts));
         //$(this).parents('tr').remove();
         var rowCount2=0;
         var table = document.getElementById("customers");
         var rows = table.getElementsByTagName("tr")
         for (var i = 0; i < rows.length; i++) {
             if (rows[i].getElementsByTagName("td").length > 0) {
                 ////alert(rows[i].getElementsByTagName("td").length);
                 rowCount2=rowCount2+1;
             }
         }

         for (var i = 1; i < (rowCount2+1); i++)
         {

             for (var d = 1; d <(Number(counts)+1); d++)
             {
                 //alert("couts="+couts);
                 var deletorder= document.getElementById("test_order"+(couts)+d).value;
                // alert("deletorder="+deletorder);
                 //alert(eval("arrcontainer"+d));
                 const iindex = eval('arrcontainer'+d).indexOf(deletorder);
                 //alert(iindex);
                 if (iindex > -1) {
                     eval('arrcontainer'+d).splice(iindex, 1); // 2nd parameter means remove one item only
                 }
                  
                // alert("i//d ="+i+d);
                 //alert("test order lenght "+i+d+"="+JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length));
                 if(JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length) == 0 && deletorder!="请选择")
                 {
                     //alert("append "+deletorder);
                    // alert("option 0="+eval("test_order"+i+d).options[1].value.charCodeAt(0));
                     
                     for(var mm=1;mm<(eval("test_order"+i+d).options.length);mm++)
                     {
                         if(deletorder.charCodeAt(0)<eval("test_order"+i+d).options[mm].value.charCodeAt(0))
                         {
                             eval("test_order"+i+d).options.add(new Option(deletorder,deletorder),eval("test_order"+i+d)[mm]);
                             break;
                         }
                     }
                     //append original selection back to container if not exit
                 }
                 //alert(eval("arrcontainer"+d));

                // alert("counts+1="+(Number(counts)+1));
                // alert("i="+i+"/ d= "+d);
                 
                 //document.getElementById("test_order"+(i+1)+d).setAttribute("id","test_order"+(i)+d);
                 
                 //document.getElementById("test_order"+(i)+d).setAttribute("onchange","testchange("+(i)+","+d+")");
                 

                 //alert()*/
             }
             /*
             document.getElementById((i+1)+"add").setAttribute("id",i+"add");                    
             document.getElementById((i+1)+"del").setAttribute("id",i+"del");
             document.getElementById((i)+"add").setAttribute("name",(i)+"add");
             document.getElementById((i)+"del").setAttribute("name",(i)+"del");
             */
            
         }
         
         $(this).parents('tr').remove();
         //alert("rowCount2+1="+(rowCount2+1));
         //alert("arrcontainer1="+arrcontainer1);
         
         //alert("rowCount2="+rowCount2+"couts="+(couts)+"counts="+counts);
         for (var i = (couts+1); i < (rowCount2+1); i++)
         {

             for (var d = 1; d <(Number(counts)+1); d++)
             {
                
                 //alert("counts+1="+(Number(counts)+1));
                // alert("getin rename");
                // alert("ii="+i+"/ dd= "+d);

                 
                 document.getElementById("test_order"+(i)+d).setAttribute("id","test_order"+(i-1)+d);
                 
                 document.getElementById("test_order"+(i-1)+d).setAttribute("onchange","testchange("+(i-1)+","+d+")");
                 
             }
            
             document.getElementById("group"+(i)).setAttribute("id","group"+(i-1));
             document.getElementById("group"+(i-1)).setAttribute("onchange","groupchange("+(i-1)+")");
             document.getElementById("test_item"+(i)).setAttribute("id","test_item"+(i-1));
             document.getElementById((i)+"add").setAttribute("id",(i-1)+"add");                    
             document.getElementById((i)+"del").setAttribute("id",(i-1)+"del");
             document.getElementById((i-1)+"add").setAttribute("name",(i-1)+"add");
             document.getElementById((i-1)+"del").setAttribute("name",(i-1)+"del");
             
         }
         
         for (var d = 1; d <(Number(counts)+1); d++)
         {
             var test_order = document.getElementById("test_order1"+d);
             var test_order_opt = test_order.options;
             var arr_testorder=[];
             //alert(test_order_opt.length);
             for(var i=0; i<test_order_opt.length; i++){

                 if(eval("arrcontainer"+d).indexOf(test_order_opt[i].value)==-1)
                 {
                     //alert(test_order_opt[i].value);
                     arr_testorder.push(test_order_opt[i].value);
                     //alert(arr_testorder[i]);
                 }
             }
             //alert(arr_testorder.length);
             //eval("oo"+d)="";
             //alert(eval("<"+"2"));     
             var p ="";
             eval("oo"+d+"=p");
             for(var j=0; j<arr_testorder.length; j++){
                 //alert(eval("oo"+d));
                 
                  p= "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
                 //alert(p);
                 eval("oo"+d+"+=p");

                 //alert(eval(S"oo"+d +"=<option value=arr_testorder["+j+"]>+arr_testorder["+j+"]+</option>")) ;
             }
         }  
        // alert(eval("oo"+1));              
     })
     
    }

function testchange(pp,ii)
{
    var totalRowCount = 0;
    var rowCount = 0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length; i++) {
        totalRowCount++;
        if (rows[i].getElementsByTagName("td").length > 0) {
            ////alert(rows[i].getElementsByTagName("td").length);
            rowCount=rowCount+1;
        }
    }
    //alert("pp="+pp);
    var totalRowCount = rowCount;
    //alert("totalRowCount="+totalRowCount);
    this["oo"+ii] = "" ; //dropdown list containter
    //alert("row/unit="+pp+"/"+ii);
    //alert(eval('original select'+pp+ii));
    var arr_testorder = Array();
    var test_order = document.getElementById("test_order"+pp+ii);
    var strUser = test_order.value; //currently row two selecton item
   // alert("this[original select"+pp+ii+"]="+this["original_select"+pp+ii]);

    /*
    if(totalRowCount==1)
    {
    
        if(strUser!="请选择"){
            this["arrcontainer"+ii].push(strUser);
        }
      //  if(this["select_temp"+ii]=="")
       // {
            this["select_temp"+ii]=strUser;
       // }

        if(JSON.stringify($("#test_order"+ii+" option[value='"+this["select_temp"+ii]+"']").length) > 0)
        {

            //alert("option exist!");
            $("#test_order"+ii+" option[value='"+this["select_temp"+ii]+"']").remove();

        }

    }
    else
    {*/
    if(strUser!="请选择"){
        this["arrcontainer"+ii].push(strUser);
    }
    //alert(this["original_select"+pp+ii]);
    //alert("1this[original_select"+pp+ii+"]="+this["original_select"+pp+ii]);
  
        if(this["original_select"+pp+ii]==undefined||this["original_select"+pp+ii]=="")
        {
        // alert("undefined");
            //alert("totalRowCount="+totalRowCount);
            this["original_select"+pp+ii]=strUser;
        // alert("this[original_select"+pp+ii+"]="+this["original_select"+pp+ii]);
            for(var aa=1; aa<totalRowCount+1; aa++)
            {
                
    
                    //alert("test order aa//ii ="+aa+ii);
                    //alert("lenght="+JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length));
                    if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) > 0&&aa!==pp)
                    {
                        
                        //this["test_order_ch"+aa+ii].options.add(new Option(this["original_select"+aa+ii],this["original_select"+aa+ii]));
                        //append original_selecttion back to container if not exit
                        //alert("option exist!");
                        $("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").remove();

                    }

                }
        }

        
        else{
            //
          //  alert("2this[original_select"+pp+ii+"]="+this["original_select"+pp+ii]);

            if(this["original_select"+pp+ii]!="请选择"){

                for(var aa=1; aa<totalRowCount+1; aa++)
                {
                    //alert("totalRowCount="+totalRowCount);
                    ////alert("totalRowCount-2="+(totalRowCount-2));
                    //alert("test order"+aa+ii+"="+this["original_select"+aa+ii]); //original row one value 
                    //this["test_order_ch"+aa+ii] = document.getElementById("test_order"+aa+ii);// row two to...other value

                    /*
                    if(this["test_order_ch"+aa+ii]){
                        this["nestrUser"+aa+ii]= this["test_order_ch"+aa+ii].value;//set row two testorder to other value 
                    }
                    */
                

                    ////alert("test order11 new value="+strUser); //row one new selection
                    ////alert("testorder"+aa+ii+"="+this["nestrUser"+pp+ii]);//row two testorder to other value 

                    if(this["original_select"+pp+ii]==undefined)
                    {
                        //this["select_temp"+ii]=strUser;
                    }
                    else
                    {
                        //alert("partII");
                    //  alert("original_select"+pp+ii+"="+this["original_select"+pp+ii]);
                            var letterpo=this["original_select"+pp+ii].charCodeAt(0)-63;
                        // alert("postions="+(this["original_select"+pp+ii].charCodeAt(0)-63));
                            const iindex = this["arrcontainer"+ii].indexOf(this["original_select"+pp+ii]);
                            if (iindex > -1) {
                                this["arrcontainer"+ii].splice(iindex, 1); // 2nd parameter means remove one item only
                            };
                            
                            ////alert("aa//ii ="+aa+ii);
                            //alert("lenght="+JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length));
                            if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) == 0)
                            {
                                //alert("option 0="+this["test_order"+aa+ii].options[1].value.charCodeAt(0));
                                
                                for(var mm=1;mm<(this["test_order"+aa+ii].options.length);mm++)
                                {
                                    if(this["original_select"+pp+ii].charCodeAt(0)<this["test_order"+aa+ii].options[mm].value.charCodeAt(0))
                                    {
                                        this["test_order"+aa+ii].options.add(new Option(this["original_select"+pp+ii],this["original_select"+pp+ii]),this["test_order"+aa+ii][mm]);
                                        break;
                                    }
                                }
                                //append original_selection back to container if not exit
                            }
                            else
                            {
                                //alert("old original selec option exist!");
                                //test_order_ch.options.add(new Option(this["original selec"+ii],this["original selec"+ii]));
                            }
                        /*
                            $("#test_order"+aa+ii).html($("#test_order"+aa+ii+" option").sort(function (a, b) {
                                return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
                            }))
                            */
                            ////alert("old original selec="+this["original selec"+ii]);
                            //this["test_order_ch"+aa+ii].value=this["nestrUser"+aa+ii];//set back to row two to other orignal value
                        


                    }
                }
            }
           // alert("strUser="+strUser);
        this["original_select"+pp+ii]=strUser; //set new testorder1 value
           // alert("orignial select"+pp+ii+ "="+this["original_select"+pp+ii]); //set new testorder1 value

            if(strUser!="请选择"){
                //this["original_select"+pp+ii]=strUser; //set new testorder1 value

                for(var aa=1; aa<totalRowCount+1; aa++){
                    
                   // alert("new value="+this["original_select"+pp+ii]);

                    if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) > 0&&aa!=pp)
                    {

                        //alert("option exist!");
                        $("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").remove();

                    }
                    /*
                    if(JSON.stringify($("#test_order"+ii+" option[value='"+this["nestrUser"+aa+ii]+"']").length) > 0)
                    {

                        //alert("option exist!");
                        $("#test_order"+ii+" option[value='"+this["nestrUser"+aa+ii]+"']").remove();

                    }*/

                }
            }
                


            

        }

    var test_order_opt = test_order.options;
    ////alert("unit num /ii="+pp+"//"+ii+"//"+ strUser);
    for(var i=0; i<this["arrcontainer"+ii].length; i++){
      //  alert("unit num//content="+ii+"//"+ this["arrcontainer"+ii][i]);
    }

    for(var i=0; i<test_order_opt.length; i++){

        if(this["arrcontainer"+ii].indexOf(test_order_opt[i].value)==-1)
        {
            arr_testorder.push(test_order_opt[i].value);
        }
    }
    for(var j=0; j<arr_testorder.length; j++){
        this["oo"+ii] += "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
    }
    
    //alert(this["oo"+ii]);
    //alert(this["arrcontainer"+ii].length);

}
window.onload = function(){


     units_qty = document.getElementById("units_qty");
     counts = units_qty.value;
    var couts = 0;
    var coutI = 0;

    for(var i=0; i<counts; i++){
        w=i+1;
        //var arrcontainer =Array(); //collect select order

        this["arrcontainer"+w] = Array();
        this["oo"+w]="";

    
    }

    for(var i=1;i<50;i++)
    {
        for(var ii=0; ii<counts; ii++){
            w=ii+1;
            //var arrcontainer =Array(); //collect select order
    
            this["original_select"+i+w] = "";    
        
        }

    }
    //var gg = ""    //用于保存option group的字符串
    var arr_group = Array();
    var group = document.getElementById("group1");
    var group_opt = group.options;    //获得该下拉框所有的option的节点对象
    for(var i=0; i<group_opt.length; i++){
        arr_group.push(group_opt[i].value);
    }
    for(var j=0; j<arr_group.length; j++){
        gg += "<option>"+arr_group[j]+"</option>";
    }

    //var tt = ""    //用于保存option test item的字符串
    var arr_testitem = Array();
    var arr_testclass=Array();
    //test_item_opt[i].getAttribute('class')
    var test_item = document.getElementById("test_item1");
    var groupval = document.getElementById("group1").value;
    var test_item_opt = test_item.options;
    for(var i=0; i<test_item_opt.length; i++){
        arr_testitem.push(test_item_opt[i].value);
        arr_testclass.push(test_item_opt[i].getAttribute('class'));
       // alert(arr_testclass[1]);
    }
    //alert(arr_testitem[0]);
    //tt+="<option value=select_item class=select_item>Select Item</option>";
    
    for(var j=0; j<arr_testitem.length; j++)
    {
        
        if(arr_testitem[j]!=""&&arr_testitem[j]!="Select_Item")
        {
            
            tt += "<option class="+arr_testclass[j].slice(6,7)+" hidden=true>"+arr_testitem[j]+"</option>";

        }
        else
        {
            tt += "<option class="+arr_testclass[j]+" hidden=true>"+arr_testitem[j]+"</option>";
   
        }

        
    }
    //added on 2021-12-03,options for test order(A,B,C...)
    //var oo = ""
    /*
    var arr_testorder = Array();
    var test_order = document.getElementById("test_order1");
    var test_order_opt = test_order.options;
    for(var i=0; i<test_order_opt.length; i++){
        arr_testorder.push(test_order_opt[i].value);
    }
    for(var j=0; j<arr_testorder.length; j++){
        oo += "<option>"+arr_testorder[j]+"</option>";
    }
    */


    for(var e=0; e<counts; e++){
        ii=e+1;
        
        var arr_testorder = Array();
        var test_order = document.getElementById("test_order1"+ii);
        var strUser = test_order.value;
        if(strUser!="请选择"){
             this["arrcontainer"+ii].push(strUser);
        }
       
        var test_order_opt = test_order.options;
        for(var i=0; i<test_order_opt.length; i++){
                arr_testorder.push(test_order_opt[i].value);
        }
        for(var j=0; j<arr_testorder.length; j++){
            this["oo"+ii] += "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
        }
        
    }

    //alert(arr_testorder.length);

  


    
    $(function(){

        $(':button[name=1add]').click(function(){
            //alert("name=1add");
            var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = $(this).closest("tr");
            //alert("JavaScript Row Index : " + (rowJavascript.rowIndex ) );
            innero(rowJavascript.rowIndex);
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")
            //alert("rows.length="+rows.length);
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    ////alert(rows[i].getElementsByTagName("td").length);
                    rowCount2=rowCount2+1;
                }
            }
            //alert("rowCount="+rowCount2);
            //addTr(rowCount2);
            //innero(1);
        })
        $('button[name=del]').click(function(){
            $(this).parents('tr').remove();
        })

        $("#group1").on("change", function(){
            //var member_id = this.value;
            var el = $(this).find(':selected');
            //alert(el.val());
            var check=0;
            //alert("group1 onchnage");
            var test_item = document.getElementById("test_item1");
            var test_item_opt = test_item.options;
            //$test_item.find("option").hide();
            //$set=test_item.find('option.'+el.val());
            //$set.show().first.prop('selectes',true);
            //var test_item_opt_class = test_item_opt[0].getAttribute('class');
            
            //$("#test_item").empty();
            //test_item_opt.removeAttribute("hidden");

            
            if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) 
            {
               // alert("Browser is Safari");  
                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                if(nodesSnapshot.snapshotLength==57)
                {
                    for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                        var nodeA = nodesSnapshot.snapshotItem(i);
                        var nodeclass=nodeA.getAttribute('class');
                        arrayclass.push(nodeclass);
                    }  
                }
                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/div", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    //alert(arrayclass[i]);
                    var elemA = document.createElement('option');
                    elemA.innerHTML = nodeA.innerHTML;
                    nodeA.parentNode.replaceChild(elemA, nodeA);
                }  

                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    //alert(arrayclass[i]);
                    var elemA = document.createElement('option');
                    elemA.setAttribute("class",arrayclass[i])
                    elemA.innerHTML = nodeA.innerHTML;
                    nodeA.parentNode.replaceChild(elemA, nodeA);
                }  

                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/option[@class!='"+el.val()+"']", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                for (var i = 1; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    var elemA = document.createElement('div');
                    elemA.innerHTML = nodeA.innerHTML;
                    nodeA.parentNode.replaceChild(elemA, nodeA);
                }       
            }
            for(var i=0; i<test_item_opt.length; i++){
                //test_item_opt[i].removeAttribute("hidden");
                //alert("class="+test_item_opt[i].getAttribute('class'));
                if(test_item_opt[i].getAttribute('class')!=el.val())
                {
                    //alert("hide");
                    //alert($(this));
                    test_item_opt[i].setAttribute("hidden",true);

                }
                else
                {
                    if(check==0)
                    {
                        document.getElementById("test_item1").options[i].selected="selected"
                    }
                    //alert("nothide");
                    test_item_opt[i].removeAttribute("hidden");
                    //if( ($(this).parent().is('span')) ) $(this).unwrap();
                    check=1;

                    
                }

                if(check==0)
                {
                    document.getElementById("test_item1").options[0].selected="selected"

                }
            }
            




        });



    })
    
    function addTr(couts){

        var html='';
        
        html+='<tr>';
        html+='<td><select name="group[]" id="group")>';
        html+=gg;
        html+='</select></td>';
       
        html+='<td><select name="test_item[]" class="selbox" id="test_item">';
        html+=tt;
        html+='</select></td>';
        counts
        for(var i=0; i<counts; i++){
            ii=i+1;
            //html+='<td><input name="test_order[]" type="text" onkeyup="value=value.replace(/[^a-zA-Z]/g,")" />';
            //html+='</td>';
            //html+='<input name="unit_order[]" type="hidden" value='+(i+1)+'>';
            //html+='<input name="unit_order[]" type="hidden" value="'+(i+1)+'" />';

            html+='<td><select class="test_order" name="test_order[]" id="test_order'+(couts+1)+ii+'" onchange="testchange('+(couts+1)+','+ii+')">';
            html+=this["oo"+ii] ;
            html+='</select></td>';
            
        }
        //alert("counts and coutI ="+couts+coutI);
        //addonchange(couts);
        //couts=coutI-1;
        //alert("couts=coutI+1; counts and coutI ="+couts+coutI);
        var rowCount=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")
        //alert("rows.length="+rows.length);
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                ////alert(rows[i].getElementsByTagName("td").length);
                rowCount=rowCount+1;
            }
        }
        //alert("rowCount="+rowCount);
        html+='<td><input type="button" id="'+(rowCount+1)+'add"  name="'+(rowCount+1)+'add" class="btn_add" value="Add" />&nbsp;&nbsp;<input type="button" id="'+(rowCount+1)+'del" name="'+(rowCount+1)+'del"  class="btn_del" value="Del" /></td>';
        html+='<tr>';
        $('#customers').append(html);

        $(':button[name='+(rowCount+1)+'add]').click(function(){
            //if(coutI==couts){
                //coutI += 1;
                var rowCount2=0;
                var table = document.getElementById("customers");
                var rows = table.getElementsByTagName("tr")
                //alert("rows.length="+rows.length);
                for (var i = 0; i < rows.length; i++) {
                    if (rows[i].getElementsByTagName("td").length > 0) {
                        ////alert(rows[i].getElementsByTagName("td").length);
                        rowCount2=rowCount2+1;
                    }
                }
                //alert("rowCount="+rowCount2);
                addTr(rowCount2);
           // }
        })
        $(':button[name='+(rowCount+1)+'del]').click(function(){
            //coutI = coutI-1;
            //alert("rowCount="+(rowCount+1));
            //$(this).parents('tr').remove();
            var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = $(this).closest("tr");
            alert("JavaScript Row Index : " + (rowJavascript.rowIndex - 1) );
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    ////alert(rows[i].getElementsByTagName("td").length);
                    rowCount2=rowCount2+1;
                }
            }

            for (var i = 1; i < (rowCount2+1); i++)
            {

                for (var d = 1; d <(Number(counts)+1); d++)
                {
                    var deletorder= document.getElementById("test_order"+(rowCount+1)+d).value;
                    //alert(deletorder);
                    //alert(eval("arrcontainer"+d));
                    const iindex = eval('arrcontainer'+d).indexOf(deletorder);
                    //alert(iindex);
                    if (iindex > -1) {
                        eval('arrcontainer'+d).splice(iindex, 1); // 2nd parameter means remove one item only
                    }
                     
                    ////alert("aa//ii ="+aa+ii);
                    //alert("test order lenght "+i+d+"="+JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length));
                    if(JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length) == 0 && deletorder!="请选择")
                    {
                        //alert("append "+deletorder);
                       // alert("option 0="+eval("test_order"+i+d).options[1].value.charCodeAt(0));
                        
                        for(var mm=1;mm<(eval("test_order"+i+d).options.length);mm++)
                        {
                            if(deletorder.charCodeAt(0)<eval("test_order"+i+d).options[mm].value.charCodeAt(0))
                            {
                                eval("test_order"+i+d).options.add(new Option(deletorder,deletorder),eval("test_order"+i+d)[mm]);
                                break;
                            }
                        }
                        //append original_selection back to container if not exit
                    }
                    //alert(eval("arrcontainer"+d));

                   // alert("counts+1="+(Number(counts)+1));
                   // alert("i="+i+"/ d= "+d);
                    
                    //document.getElementById("test_order"+(i+1)+d).setAttribute("id","test_order"+(i)+d);
                    
                    //document.getElementById("test_order"+(i)+d).setAttribute("onchange","testchange("+(i)+","+d+")");
                    

                    //alert()*/
                }
                /*
                document.getElementById((i+1)+"add").setAttribute("id",i+"add");                    
                document.getElementById((i+1)+"del").setAttribute("id",i+"del");
                document.getElementById((i)+"add").setAttribute("name",(i)+"add");
                document.getElementById((i)+"del").setAttribute("name",(i)+"del");
                */
               
            }
            
            $(this).parents('tr').remove();
            //alert("rowCount2+1="+(rowCount2+1));
            //alert("arrcontainer1="+arrcontainer1);
            
            
            for (var i = (rowCount+1); i < (rowCount2); i++)
            {

                for (var d = 1; d <(Number(counts)+1); d++)
                {
                   
                    //alert("counts+1="+(Number(counts)+1));
                    //alert("i="+i+"/ d= "+d);
                    
                    document.getElementById("test_order"+(i+1)+d).setAttribute("id","test_order"+(i)+d);
                    
                    document.getElementById("test_order"+(i)+d).setAttribute("onchange","testchange("+(i)+","+d+")");
                    
                }
                document.getElementById("group"+(i+1)).setAttribute("id","group"+(i));
                document.getElementById("group"+(i+1)).setAttribute("onchange","groupchange("+i+")");
                document.getElementById("test_item"+(i+1)).setAttribute("id","test_item"+(i));
                document.getElementById((i+1)+"add").setAttribute("id",i+"add");                    
                document.getElementById((i+1)+"del").setAttribute("id",i+"del");
                document.getElementById((i)+"add").setAttribute("name",(i)+"add");
                document.getElementById((i)+"del").setAttribute("name",(i)+"del");
                
            }
            
            for (var d = 1; d <(Number(counts)+1); d++)
            {
                var test_order = document.getElementById("test_order1"+d);
                var test_order_opt = test_order.options;
                var arr_testorder=[];
                //alert(test_order_opt.length);
                for(var i=0; i<test_order_opt.length; i++){

                    if(eval("arrcontainer"+d).indexOf(test_order_opt[i].value)==-1)
                    {
                        //alert(test_order_opt[i].value);
                        arr_testorder.push(test_order_opt[i].value);
                        //alert(arr_testorder[i]);
                    }
                }
                //alert(arr_testorder.length);
                //eval("oo"+d)="";
                //alert(eval("<"+"2"));     
                var p ="";
                eval("oo"+d+"=p");
                for(var j=0; j<arr_testorder.length; j++){
                    //alert(eval("oo"+d));
                    
                     p= "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
                    //alert(p);
                    eval("oo"+d+"+=p");

                    //alert(eval(S"oo"+d +"=<option value=arr_testorder["+j+"]>+arr_testorder["+j+"]+</option>")) ;
                }
            }  
           // alert(eval("oo"+1));              
        })


        
    }


    
 



   


    // loading animation added on 2022-01-06<option>请选择</option><option>A</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>Z</option><option>N/A</option><option>请选择</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>Z</option><option>N/A</option><option>请选择</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>Z</option><option>N/A</option>
    $(document).ready(function(){
        $("#form2").on("submit", function(){
            $("#preloder").fadeIn();
        });//submit


    });//document ready

}