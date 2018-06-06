
function Chmurka(T,t){
 T.title=''
  T.parentNode.lastChild.style.display=t?'block':'none'
  }																

function displayWindow(url, width, height, name) 
    { 
        var Win = window.open(url, name,'width=' + width + ',height=' + height + ',left = 0' + ',top = 0' + ',resizable=yes,scrollbars=yes,menubar=yes, toolbar = yes, bgcolor = #000000' ); 
        Win.document.bgColor='#E7E0CD';  			  
} 
			
function fokus(AElementID)
	{    
		var el = document.getElementById(AElementID);    
		el.focus();
	}