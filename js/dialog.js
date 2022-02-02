//********************BEGIN*******************//

var classDialog = new ConstantsDialog();

function ConstantsDialog() { 	
	
		this.dialogWidth = 350;
		this.dialogHeight = 150;
		this.PROG ='';
		var scrollYX = getScrollXY();
		var s = scrollYX.split(',');	
		var x = parseInt(s[0]), y = parseInt(s[1]);
  		var myWidth = 0, myHeight = 0;
  	
	  	myWidth  = window.innerWidth;
		myHeight = window.innerHeight;
		
   		x = parseInt(x + ( myWidth / 2 ) - (this.dialogWidth / 2)); 
 	 	y = parseInt(y + ( myHeight / 2 ) - (this.dialogHeight / 2));    
	
	var iconCache = new Image();
		iconCache['ICON_SIMPLE']  = ' ';
		iconCache['ICON_CONFIRM'] = 'images/exec.png';
		iconCache['ICON_WARNING'] = 'images/important.png';
		iconCache['ICON_ERROR']   = 'images/error.png';
		iconCache['ICON_TRASH']   = 'images/trashcan-empty.png';
		iconCache['ICON_CONSOLE'] = 'images/console.png';
		iconCache['ICON_HARD']    = 'images/harddrive.png';
		iconCache['ICON_CLOSE']   = 'images/close.png';
		iconCache['ICON_OK']  	  = 'images/ok.png';
		iconCache['ICON_PROG']    = 'images/progress.gif';
		iconCache['ICON_DB']    = 'images/db.png';
		
	this.dialogIconObject = { 
		ICON_SIMPLE :  iconCache['ICON_SIMPLE'],
		ICON_CONFIRM : iconCache['ICON_CONFIRM'],
		ICON_WARNING : iconCache['ICON_WARNING'],
		ICON_ERROR :   iconCache['ICON_ERROR'],
		ICON_TRASH :   iconCache['ICON_TRASH'],
		ICON_CONSOLE : iconCache['ICON_CONSOLE'],
		ICON_HARD :    iconCache['ICON_HARD'],
		ICON_OK :      iconCache['ICON_OK'],
		ICON_PROG :    iconCache['ICON_PROG'],
		ICON_DB :      iconCache['ICON_DB']
		};
	this.eventDialogObject = {};	
	this.showDialogObject  = {}; 

	
	this.title   = '';
	this.message = '';
	this.DIALOG  = '';
	this.ICON    = '';
	this.bOK     = 'OK';
	this.bCancel = 'Cancel';
	this.whence  = ''
	this.catchValueField='';
	this.iconDialogHeaderClose = iconCache['ICON_CLOSE'];
	
	this.idDialogButtonOK      = "dialogButtonOK";
	this.idDialogButtonCancel  = "dialogButtonCancel";
	this.idDialog              = "dialog";
	this.idDialogMoveBox       = "dialogMoveBox";
	this.idDialogImgClose      = "dialogImgClose";
	this.idDialogField         = "dialogField";
    this.idDialogSimple        = "dialogSimple";
	this.idDialogProgress      = "dialogProgress";
	this.layout                = "layout";
	
	this.styleDialogGlobal       = "left:"+x+"px;top:"+y+"px;"+"width:"+this.dialogWidth+"px; height:"+this.dialogHeight+"px;"; // style box
	this.styleDialogHeader       = "width:auto; height:15px;color:#FFF; background:#05435C; border-bottom: 1px solid #98A0A3; padding:5px; cursor:pointer";
	this.styleDialogIcon         = "width:50px; float:left; height:100px; margin:20px;";
	this.styleDialogMessage      = "width:250px; float:left; height:auto; margin-top:10px; margin-bottom:5px;";
	this.styleDialogButton       = "float:left; width:250px; height:0px; margin:0px;";
	this.styleDialogField        = "border:1px solid gray;";

	this.regField = '\^[0-9\_.-\a-z\'\" \s]\+$';
}

function listener() {
	eventDialogObject.listenerButtonOK();
	eventDialogObject.listenerButtonCancel();
	eventDialogObject.listenerImgClose();	
	eventDialogObject.listenerField(); 
}

showDialogObject = { 
	
	dialogSimple : function(param, title, message, icon) { 
		classDialog.DIALOG ='DIALOG_SIMPLE';
		classDialog.title   = title;
		classDialog.message = message;
		classDialog.ICON    = icon;
		
		createDialogDOM();
	},
	dialogConfirm : function(param, title, message, icon, bOK, bCancel) { 
		classDialog.DIALOG ='DIALOG_CONFIRM';
		classDialog.title   = title;
		classDialog.message = message;
		classDialog.ICON    = icon;
		if(bOK != null) classDialog.bOK = bOK;
		if(bCancel != null) classDialog.bCancel = bCancel;
		
		createDialogDOM();
	},
	dialogStandard : function(param, title, message, icon, bOK) { 
		classDialog.DIALOG  = 'DIALOG_STANDARD';
		classDialog.title   = title;
		classDialog.message = message;
		classDialog.ICON    = icon;
		if(bOK != null) classDialog.bOK = bOK;
		
		createDialogDOM();
	},
	dialogField : function(param, title, message, icon, bOK, bCancel) { 
		classDialog.DIALOG ='DIALOG_FIELD';
		classDialog.title   = title;
		classDialog.message = message;
		classDialog.ICON    = icon;
		if(bOK != null) classDialog.bOK = bOK;
		if(bCancel != null) classDialog.bCancel = bCancel;
		
		createDialogDOM();
	},
	dialogPassword : function() { 
		classDialog.DIALOG ='DIALOG_PASSWORD';
		return false;
	},
	
	dialogProgress : function(param, title, message, icon) { 
		classDialog.DIALOG ='DIALOG_PROGRESS';
		classDialog.title   = title;
		classDialog.message = message;
		classDialog.ICON    = icon;
		
		createDialogDOM();
	}  	
};

eventDialogObject = { 
	
	listenerButtonOK : function() { 
			if(document.getElementById(classDialog.idDialogButtonOK)) {
				var iconClose = document.getElementById(classDialog.idDialogButtonOK);
				if(iconClose.addEventListener) { 
					iconClose.addEventListener("click", eventButtonOK, false);		
				} else if(iconClose.attachEvent) {
					iconClose.attachEvent("onclick", eventButtonOK);	
				}
			}
		},
	listenerButtonCancel : function() { 
		if(document.getElementById(classDialog.idDialogButtonCancel)) {
				var iconClose = document.getElementById(classDialog.idDialogButtonCancel);
				if(iconClose.addEventListener) { 
					iconClose.addEventListener("click", eventButtonCancel, false);		
				} else if(iconClose.attachEvent) {
					iconClose.attachEvent("onclick", eventButtonCancel);	
				}
			}
		},
		
	listenerImgClose : function() { 
		if(document.getElementById(classDialog.idDialogImgClose)) {
				var iconClose = document.getElementById(classDialog.idDialogImgClose);
				if(iconClose.addEventListener) { 
					iconClose.addEventListener("click", closeDialog, false);		
				} else if(iconClose.attachEvent) {
					iconClose.attachEvent("onclick", closeDialog);	
				}
			}
		},
	listenerField : function() { 
		if(document.getElementById(classDialog.idDialogField)) {
				var iconClose = document.getElementById(classDialog.idDialogField);
				if(iconClose.addEventListener) { 
					iconClose.addEventListener("keypress", eventField, false);		
				} else if(iconClose.attachEvent) {
					iconClose.attachEvent("onkeypress", eventField);	
				}
			}
		}	
				
};

function closeDialog() { 
 
	if(document.getElementById(classDialog.idDialog)) {
		document.getElementById(classDialog.idDialog).style.display='none';
		document.getElementById(classDialog.layout).style.display='none'; 
		removeDialogDOM();	
	}
}

function openDialog() {
	if(!document.getElementById(classDialog.idDialogMoveBox)) {
		document.getElementById(classDialog.idDialog).style.display='inline'; 
		layout();
	}	
}

function removeDialogDOM() {
	if(document.getElementById(classDialog.idDialog) && document.getElementById(classDialog.idDialogMoveBox)) {
		var dialog = document.getElementById(classDialog.idDialog);
		var box = document.getElementById(classDialog.idDialogMoveBox);
		return dialog.removeChild(box);
	} else {
		return false;
	}
}



function createDialogDOM() {
	if(typeof(classDialog.DIALOG) != 'string') { return false; }
	
	var dialogGlobal = document.createElement ("div");
		dialogGlobal.setAttribute('id',classDialog.idDialogMoveBox);
		dialogGlobal.setAttribute('class',"box");
		dialogGlobal.setAttribute('style', classDialog.styleDialogGlobal);
		
	var dialogHeader = document.createElement('div');
		dialogHeader.setAttribute('style',classDialog.styleDialogHeader);
		dialogHeader.setAttribute('onmousedown',"");
	
	//-----------------------Header--------------------------
	var dialigHeaderTitleLeft = document.createElement('div');
		dialigHeaderTitleLeft.setAttribute('style',"float:left; text-transform: uppercase;");
	var dialogHeaderTitleTXT = document.createTextNode(classDialog.title);
		dialigHeaderTitleLeft.appendChild(dialogHeaderTitleTXT);
				
	var dialigHeaderTitleRight = document.createElement('div');
		dialigHeaderTitleRight.setAttribute('style',"float:right;");
	var dialogHeaderTitleIMG = document.createElement('img');
		dialogHeaderTitleIMG.setAttribute('src',classDialog.iconDialogHeaderClose);
		dialogHeaderTitleIMG.setAttribute('id',classDialog.idDialogImgClose);
		dialogHeaderTitleIMG.setAttribute('onclick',"");
		
		dialigHeaderTitleRight.appendChild(dialogHeaderTitleIMG);	
	//-----------------------Header--------------------------
		
	var dialogIcon = document.createElement('div');	
		dialogIcon.setAttribute('style',classDialog.styleDialogIcon);
	var dialogIconAdd = document.createElement('img');
		dialogIconAdd.setAttribute('src',classDialog.ICON);		
		dialogIcon.appendChild(dialogIconAdd);
	
	var dialogMessage = document.createElement('div');	
		dialogMessage.setAttribute('style',classDialog.styleDialogMessage);
	var	dialogMessageTxt = document.createTextNode(classDialog.message);		
		dialogMessage.appendChild(dialogMessageTxt);
	
	var dialogButton = document.createElement('div');
	
	if(classDialog.DIALOG == 'DIALOG_SIMPLE') { 
        dialogButton.setAttribute('id',classDialog.idDialogSimple);
        dialogButton.setAttribute('style','float:left'); 
    } 	
	
	 
	
	if(classDialog.DIALOG == 'DIALOG_PROGRESS') { 
		 
        dialogButton.setAttribute('id',classDialog.idDialogProgress);
        dialogButton.setAttribute('style','float:left');


    } 
	
	
	if(classDialog.DIALOG == 'DIALOG_CONFIRM') { }
	if(classDialog.DIALOG == 'DIALOG_PASSWORD') { }
	
	if(classDialog.DIALOG == 'DIALOG_FIELD') { 
		var dialogField = document.createElement('div');
			dialogField.setAttribute('style','float:left;width:250px; height:25px;');
		var	dialogInputField = document.createElement('input');	
			dialogInputField.setAttribute('type','text');
			dialogInputField.setAttribute('id', classDialog.idDialogField);
			dialogInputField.setAttribute('style', classDialog.styleDialogField);
			dialogInputField.setAttribute('class', 'fielddefault');
			dialogInputField.setAttribute('onkeypress','');	
			dialogField.appendChild(dialogInputField);
	}
	
	if(classDialog.DIALOG == 'DIALOG_STANDARD') { 
		var dialogButton = document.createElement('div');	
			dialogButton.setAttribute('style',classDialog.styleDialogButton);
		
		var	dialogButtonStandard = document.createElement('input');
			dialogButtonStandard.setAttribute('value',classDialog.bOK);	
			dialogButtonStandard.setAttribute('type',"button");	
			dialogButtonStandard.setAttribute('id',classDialog.idDialogButtonOK);	
			dialogButtonStandard.setAttribute('class','buttondefault');	
			dialogButtonStandard.setAttribute('onclick','');
			dialogButton.appendChild(dialogButtonStandard);
	}
	
	if(classDialog.DIALOG == 'DIALOG_FIELD' || classDialog.DIALOG == 'DIALOG_CONFIRM') { 
		var dialogButton = document.createElement('div');	
			dialogButton.setAttribute('style',classDialog.styleDialogButton);
		var	dialogButtonOK = document.createElement('input');
			dialogButtonOK.setAttribute('value',classDialog.bOK);	
			dialogButtonOK.setAttribute('type',"button");	
			dialogButtonOK.setAttribute('id',classDialog.idDialogButtonOK);	
			dialogButtonOK.setAttribute('class','buttondefault');		
			dialogButtonOK.setAttribute('onclick','');
		
		var	dialogButtonCancel = document.createElement('input');
			dialogButtonCancel.setAttribute('value',classDialog.bCancel);	
			dialogButtonCancel.setAttribute('type',"button");	
			dialogButtonCancel.setAttribute('id',classDialog.idDialogButtonCancel);	
			dialogButtonCancel.setAttribute('class','buttondefault');	
			dialogButtonCancel.setAttribute('onclick','');	
			
			dialogButton.appendChild(dialogButtonOK);	
			dialogButton.appendChild(dialogButtonCancel);
	}

	dialogHeader.appendChild(dialigHeaderTitleLeft);
	dialogHeader.appendChild(dialigHeaderTitleRight);	
		
	dialogGlobal.appendChild(dialogHeader);
	dialogGlobal.appendChild(dialogIcon);
	dialogGlobal.appendChild(dialogMessage);
	if(classDialog.DIALOG == 'DIALOG_FIELD') dialogGlobal.appendChild(dialogField);
	dialogGlobal.appendChild(dialogButton);
	
	document.getElementById(classDialog.idDialog).appendChild(dialogGlobal);
	
} 

this.loaded=1; this.prog = 1;
function progress() { 
 
	var pr = document.getElementById(classDialog.idDialogProgress);
	pr.style.width=this.prog+"px";
		
 	this.loaded++;
 	this.prog+=5;
 							
	var progression = Math.round(100 * this.loaded / 50);
	if(progression > 30)
		var loaded =" % loaded";
	else 
		var loaded ='';	
	
	pr.innerHTML = progression + loaded;
	if(progression >= 100 ) { 
		this.loaded =1; this.prog=1;
		window.clearInterval(classDialog.PROGRESS);
		classDialog.PROGRESS = '';
    }
}

function getScrollXY() {
	
	var scrOfX = 0, scrOfY = 0;
	if(typeof(window.pageYOffset) == 'number' ) {
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	} else if(document.body && (document.body.scrollLeft || document.body.scrollTop )) {
		//DOM compliant
		scrOfY = document.body.scrollTop;
		scrOfX = document.body.scrollLeft;
	} else if(document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop )) {
		//IE6 standards compliant mode
		scrOfY = document.documentElement.scrollTop;
		scrOfX = document.documentElement.scrollLeft;
	}
	return scrOfX+","+scrOfY; 
}

function getWindowSize() {
	
	var myWidth = 0, myHeight = 0;
	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		myWidth = window.innerWidth;
		myHeight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
		myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myWidth = document.body.clientWidth;
		myHeight = document.body.clientHeight;
	}
	return myWidth+","+myHeight; 
} 


window.addEventListener('scroll', function() { 
		var scrollYX = getScrollXY();
		var s = scrollYX.split(',');	
		var x = parseInt(s[0]), y = parseInt(s[1]);
  		var myWidth = 0, myHeight = 0;
  	
	  	myWidth  = window.innerWidth;
		myHeight = window.innerHeight;

   		x = parseInt(x + ( myWidth / 2 ) - (classDialog.dialogWidth / 2)); 
 	 	y = parseInt(y + ( myHeight / 2 ) - (classDialog.dialogHeight / 2)); 
 	 	classDialog.styleDialogGlobal = "z-index: 10000000;"+"left:"+x+"px;top:"+y+"px;"+"width:"+classDialog.dialogWidth+"px; height:"+classDialog.dialogHeight+"px;"; // style box

 	 	if(document.getElementById(classDialog.idDialogMoveBox)) {
			document.getElementById(classDialog.idDialogMoveBox).style.left=x+'px';
 	 		document.getElementById(classDialog.idDialogMoveBox).style.top=y+'px';
 	 		layout();
 	 	}
	}, 
	false);


window.addEventListener('resize', function() { 
		var scrollYX = getScrollXY();
		var s = scrollYX.split(',');	
		var x = parseInt(s[0]), y = parseInt(s[1]);
  		var myWidth = 0, myHeight = 0;
  	
	  	myWidth  = window.innerWidth;
		myHeight = window.innerHeight;

   		x = parseInt(x + ( myWidth / 2 ) - (classDialog.dialogWidth / 2)); 
 	 	y = parseInt(y + ( myHeight / 2 ) - (classDialog.dialogHeight / 2)); 
 	 	classDialog.styleDialogGlobal = "left:"+x+"px;top:"+y+"px;"+"width:"+classDialog.dialogWidth+"px; height:"+classDialog.dialogHeight+"px;"; // style box

 	 	if(document.getElementById(classDialog.idDialogMoveBox)) {
 	 		document.getElementById(classDialog.idDialogMoveBox).style.left=x+'px';
 	 		document.getElementById(classDialog.idDialogMoveBox).style.top=y+'px';
 	 		layout();
 	 	}
 	 	
	}, 
	false);

function layout() {	
	
		var scrollXY = getScrollXY();
		var scrollXY = scrollXY.split(',');
		var scrollX  = parseInt(scrollXY[0]); 
		var scrollY  = parseInt(scrollXY[1]);
		
		var sizeWH   = getWindowSize();
		var sizeWH   = sizeWH.split(',');
		var sizeW    = parseInt(sizeWH[0]);
		var sizeH    = parseInt(sizeWH[1]);
		
  	if(document.getElementById(classDialog.layout)) {	
	var layout = document.getElementById(classDialog.layout, 'div');
	 
		layout.style.display         = "inline";
		layout.style.opacity         = "0.5";
		layout.style.backgroundColor = "gray";
		layout.style.position        = "absolute";
		layout.style.top             = "0px";
		layout.style.left            = "0px";
		layout.style.right           = "0px";
		layout.style.height          = (scrollY + sizeH)+"px";	
  	}	
}




