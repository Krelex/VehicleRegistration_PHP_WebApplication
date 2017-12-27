function ValidateForm(forma){
	
		var re = /(0[1-9]|[1-2][0-9]|3[0-1])+\.(0[1-9]|1[0-2])+\.[0-9]{4} (2[0-3]|[01][0-9]):[0-5][0-9]/;
		var elementi = document.forms[forma];
		var poruka = "";
		var praznih=0;
		
		
		if(forma=="frmvozilo"){
		
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value==""){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";	
				}

				//document.getElementById("poruka").innerHTML=poruka; 
			}
		
		}
		
		
		if(forma=="frmplati"){
		
			for (var i=0;i<elementi.length;i++){
				if(elementi[i].value==""){
				praznih++;
				poruka+="<br>Element "+elementi[i].id+" nije popunjen!";
				
				if(elementi[i].id=="datum"){
					
					
			
					var datum = elementi[i].value;

					if(re.test(datum) == false) {
					poruka+="<br>Pogrešan oblik datuma";
					praznih++;
					}
					
				}
				
				if(elementi[i].id=="vrijeme"){

					var vrijeme = elementi[i].value;
					
					var vrreg = /^([01][1-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
				}
				
				}

			}
			
		}
				
		
		if(praznih>0){
			document.getElementById("poruka").innerHTML=poruka;
			return false;
		}		
		
	}
	
function PretvoriVelika(){
	
	var reg = document.getElementById("registracija").value;
	
	document.getElementById("registracija").value = reg.toUpperCase();
	
}