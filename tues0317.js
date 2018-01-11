window.APP = window.APP || {};
(function($){
    jQuery.fn.putCursorAtEnd = function()
    {
    return this.each(function()
    {
        $(this).focus()

        // If this function exists...
        if (this.setSelectionRange)
        {
        // ... then use it
        // (Doesn't work in IE)

        // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
        var len = $(this).val().length;
        this.setSelectionRange(len, len);
        }
        else
        {
        // ... otherwise replace the contents with itself
        // (Doesn't work in Google Chrome)
        $(this).val($(this).val());
        }

        // Scroll to the bottom, in case we're in a tall textarea
        // (Necessary for Firefox and Google Chrome)
        this.scrollTop = 999999;
    });
    };
})(jQuery);//Puts the text cursor at the end of input after certain focus events
(function ($, undefined) {
    $.fn.getCursorPosition = function() {
        var el = this.get(0);
        var pos = 0;
        if('selectionStart' in el) {
            pos = el.selectionStart;
        } else if('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
})(jQuery);//Check the text cursor position for hopping between inputs
(function() {

  this.Modal = function() {

    this.closeButton = null;
    this.modal = null;
    this.overlay = null;

    this.transitionEnd = transitionSelect();

    var defaults = {
      autoOpen: false,
      className: 'fade-and-drop',
      closeButton: true,
      content: "",
      maxWidth: 700,
      minWidth: 280,
      overlay: true,
      maxHeight:500,
      minHeight:300
    }

    if (arguments[0] && typeof arguments[0] === "object") {
      this.options = extendDefaults(defaults, arguments[0]);
    }else {
    	this.options = defaults;
    }

    if(this.options.autoOpen === true) this.open();

  }

  Modal.prototype.close = function() {
  	$('html').removeClass('modal-open');
    var _ = this;
    this.modal.className = this.modal.className.replace(" scotch-open", "");
    this.overlay.className = this.overlay.className.replace(" scotch-open",
      "");
    this.modal.addEventListener(this.transitionEnd, function() {
      _.modal.parentNode.removeChild(_.modal);
    });
    this.overlay.addEventListener(this.transitionEnd, function() {
      if(_.overlay.parentNode) _.overlay.parentNode.removeChild(_.overlay);
    });
  }

  Modal.prototype.open = function() {
    buildOut.call(this);
    initializeEvents.call(this);
    $('html').addClass('modal-open');
    window.getComputedStyle(this.modal).height;
    this.modal.className = this.modal.className +
      (this.modal.offsetHeight > window.innerHeight ?
        " scotch-open scotch-anchored" : " scotch-open");
    this.overlay.className = this.overlay.className + " scotch-open";
  }

  function buildOut() {

    var content, contentHolder, docFrag;

    if (typeof this.options.content === "string") {
      content = this.options.content;
    } else {
      content = this.options.content.innerHTML;
    }
    
    docFrag = document.createDocumentFragment();

    this.modal = document.createElement("div");
    this.modal.className = "scotch-modal " + this.options.className;
    this.modal.style.minWidth = this.options.minWidth + "px";
    this.modal.style.maxWidth = this.options.maxWidth + "px";
    this.modal.style.minHeight = this.options.minHeight + "px";
    this.modal.style.maxHeight = this.options.maxHeight + "px";

    if (this.options.closeButton === true) {
      this.closeButton = document.createElement("button");
      this.closeButton.className = "scotch-close close-button";
      this.closeButton.innerHTML = "&times;";
      this.modal.appendChild(this.closeButton);
    }

    if (this.options.overlay === true) {
      this.overlay = document.createElement("div");
      this.overlay.className = "scotch-overlay " + this.options.className;
      docFrag.appendChild(this.overlay);
    }

    contentHolder = document.createElement("div");
    contentHolder.className = "scotch-content";
    contentHolder.innerHTML = content;
    this.modal.appendChild(contentHolder);

    docFrag.appendChild(this.modal);

    document.body.appendChild(docFrag);

  }

  function extendDefaults(source, properties) {
    var property;
    for (property in properties) {
      if (properties.hasOwnProperty(property)) {
        source[property] = properties[property];
      }
    }
    return source;
  }

  function initializeEvents() {

    if (this.closeButton) {
      this.closeButton.addEventListener('click', this.close.bind(this));
    }

    if (this.overlay) {
      this.overlay.addEventListener('click', this.close.bind(this));
    }

  }

  function transitionSelect() {
    var el = document.createElement("div");
    if (el.style.WebkitTransition) return "webkitTransitionEnd";
    if (el.style.OTransition) return "oTransitionEnd";
    return 'transitionend';
  }

}());//Create modal function
lng = function(text,lang) {
	var langlow=lang.toLowerCase();
	var lg = 'en';
	if(typeof(window.PAYS)!="undefined") {
		lg = window.PAYS;
	}
	return(lg.match(langlow)?text:""); 
}
detectmob = function() { 
 if( navigator.userAgent.match(/Mobile|Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone/i)
// || navigator.userAgent.match(/webOS/i)
// || navigator.userAgent.match(/iPhone/i)
// || navigator.userAgent.match(/iPad/i)
// || navigator.userAgent.match(/iPod/i)
// || navigator.userAgent.match(/BlackBerry/i)
// || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}
type = function(){
	var dest=$(destination);
	dest.val(text.substr(0, currentChar));
	currentChar++
	/*if (currentChar>text.length){
		currentChar=1;
		setTimeout("type()", 5000);
	}
	else{
		setTimeout("type()", delay);
	}*/
	if (currentChar<=text.length){
		setTimeout("type()", delay);
	}
}
startTyping = function(textParam, delayParam, destinationParam){
	text=textParam;
	delay=delayParam;
	currentChar=1;
	destination=destinationParam;
	type();
}
APP.init = function () {
	APP.currentpage=1;
	APP.telclicknum=0;
	window.ijuststartedaget=0;
	window.ijustfinishedaget='';
	$("td.ab3:nth-child(2)").removeClass("ab3").css({
		"text-align":"right"
	});//Search done in X seconds dialogue
	if(typeof(myoldv)=="string"){
		$('#bannerisaac').append('<div id="retourne" title="selectim.com..."style="position: absolute; z-index: 10; top: 30%; left: 1%; background-color: rgb(123, 222, 183); color: rgb(90, 90, 90); padding: 5px; border: 1px solid rgb(90, 90, 90); border-radius: 3px; cursor: pointer;"><span class="oi" data-glyph="info"></span> '+lng("utiliser l'ancienne version",'Fr')+lng('Use the old version','En')+lng('Utilizar a versão antiga','Pt')+'</div>');
	}
	$('#retourne').click(function(){
		top.location=myoldv;
	});
	iloading = new Image(100,100);
	iloading.src = "/body_a/ajax_loader_gray_350.gif";
	APP.loadertable = $('<tr id="loadertable"><td colspan="9"style="text-align:center;padding-top:100px;"><img></img></td></tr>').find('img').attr('src',iloading.src);
	$("#mylittletable").remove();
	$('#mylittletable').remove();
	$('html').css("overflow-x","hidden");
	$('#dynputdiv').removeClass('sydynw');
	$('#dynputdiv').css({'margin-left':'1%','display':'inline-block','position':'relative'});
	window.APP.viewcount = 0;
	$('#APP-inbox textarea').jqte({source: false, unlink: false, link: false});
	$.getScript( "jquery.printElement.js", function( data  ) {
	});
	/*Main input container HTML: */
	/*$('body').append('<div id="pullout"><div class="listmode nodisplay"><div class="listmode-cat lmc-001"></div><div class="listmode-cat lmc-002"></div><div class="listmode-cat lmc-003"></div><div class="listmode-cat lmc-004"></div><div class="listmode-cat lmc-005"></div></div><div id="pullout-handle" data-toggle=".listmode"> ||| </div></div>');*/
	$('body').append('<div class="tooltip nodisplay" style="background-color:white;z-index:999999;position:fixed;border:1px solid black; border-radius:3px;padding: 3px;"></div>');
	$.get('searchbar-ajax.php?t='+CharChoice+'&lg='+window.PAYS, function(data) {
		$('#dynputdiv').append(data);
	}).done(function(){
		$('<div class="nodisplay" style="position: fixed; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.57); z-index: 2147483647; left: 0px; top: 0px;">'+
		'<div style="display: inline-block; position: fixed; left: 35%; background-color: white; color: rgb(92, 92, 92); border-radius: 3px; padding: 30px; top: 35%;">'+
			'<div id="selectim-exit-close" style="position: absolute; cursor: pointer; top: 1%; left: 96.5%;">x</div>'+
			'<div style="padding: 3px; margin-top: 5px;">Before you leave, could you leave a comment</div>'+
			'<div style="padding: 3px;">'+
				'<textarea placeholder="Bugs, annoyances,etc?" style="resize: none; height: 60px; padding: 3px; width: 80%; font:inherit; font-size: small; text-align: left;"></textarea>'+
			'</div>'+
			'<div style="padding: 3px;">'+
				'<button class="selectim-exit-yes" style="border: medium none; padding: 3px; background-color: rgb(123, 171, 231); margin-right: 5px; color: white; border-radius: 3px; cursor: pointer; font: inherit;">Yes</button>'+
				'<button class="selectim-exit-no" style="border: medium none; padding: 3px; background-color: rgb(123, 171, 231); margin-right: 5px; color: white; border-radius: 3px; cursor: pointer; font: inherit;">No</button>'+
			'</div>'+
		'</div>'+
	'</div>').insertAfter('#retourne');
		APP.input = $("#APP-input");
		APP.initpos = $("#dynputdiv").position().top;
		//$("td.hb3:nth-child(1) > table:nth-child(1) > tbody:nth-child(1) > tr:nth-child(1) > td:nth-child(30) > input:nth-child(1)").addClass("hidden");
		//$('<input id="ghost" class="alpha60 APP-input" style="pointer-events:none;position:absolute;left:0;" size="60"autocomplete="off" disabled></input>').insertBefore($('#APP-input'));
		APP.setup.initobjects();
		APP.openurl=decodeURIComponent(window.uri1);
		APP.workers.adCall("init",APP.openurl,1);
		APP.workers.checkBookmarks();
		APP.setup.setlisteners();
		APP.input.focus();
	});
};
APP.setup = {
	setlisteners: function() {
		//LONGFORM SEARCH FORM LISTENERS--------------------------------------------------------------------------------
		$('#APP-inpcase').on('keyup','#plan-ville-textarea',function(event){
			var oldpak='';
			if(typeof(APP.oldpak)!="undefined"&&APP.oldpak!=""){
				oldpak="&oldpak="+APP.oldpak[1]+"&oldcmd="+APP.oldpak[0];
			}
			if(!APP.workers.validateKey(event.which)){return;}
			var vval = $(this).val();
			$('#plan-ville input').val(vval);
			$('#APPville').val(vval);
			$('#truvalville').text('ville=<"'+ vval.replace(/([\x28][^\x29]*[\x29])/,'')+'"');
			var x = "portu2";if(typeof(window.PAYS)!="undefined"){if(window.PAYS=="fr"){x="fr1";}}
			//if(typeof(lastword[lastword.length-1])=='string'&&lastword[lastword.length-1].length>0){
			$.getJSON("autocomplete"+x+".php?cmdname=ville&excl=1"+oldpak+"&term="+vval,
				function(result){
					APP.villeResult=[];
					$('#plan-ville').find('tr').remove();
					for(item in result){
						if(result[item].cmdname == "ville"){
							APP.villeResult.push(result[item]);
							$('#plan-ville .plan-submenu table').append(result[item].dis);
						}
					}
					if(APP.villeResult.length>0){
						$('#plan-ville .plan-submenu').removeClass('hidden');
						$('#plan-ville .plan-submenu tr:first-of-type').addClass('taken');
					}else{
						$('#plan-ville .plan-submenu').addClass('hidden');
					}
				});
			//}
		});//Ville quadbox keyup
		$('#APP-inpcase').on('keydown','.quadbar-spacerinp, #plan-ville-textarea',function(e){
			$(this).removeClass('invalid-page');
			var sibs = $(this).siblings('.plan-submenu');
			/*if($(this).is('#plan-ville-textarea')){
				sibs = $(this).parent().siblings('.plan-submenu');
			}*/
			APP.pageselect(e,sibs.find('tr'));
			if(e.which=="9"&&$(this).parents('.quadbar-spacer').attr('id')=="plan-ville"){
				if(sibs.find('tr').hasClass('taken')){
					e.preventDefault();
					sibs.find('.taken').click();
				}else{
					$(this).parent().addClass('nodisplay');
				}
					//APP.workers.insertSpacer('ville','ville=<"'+$(this).val()+'"',$('#plan-ville .plan-submenu table').data('title'),$(this).val(),$('#plan-ville .plan-submenu table').data('cat'),'oldput');
			}else{
				if(e.which=="9"&&$(this).parents('.quadbar-spacer').attr('id')!="plan-ville"){
					if($(this).siblings('.plan-submenu').find('.taken').length){
						$(this).siblings('.plan-submenu').find('.taken').click();
						if(($(this).parent().attr('id')=="plan-ville")||($(this).parent().attr('id')=="plan-BIENS"||$(this).parent().attr('id')=="plan-an")){
							e.preventDefault();
						}
					}
				}
			}
			if(e.which=="13"){ // Key 13 Return
				if($(this).hasClass('plan-min')||$(this).hasClass('plan-max')){
				
				var x = $(this).parents('.quadbar-spacer').attr('id').replace('plan-','');
			var v = $(this).val();
			var w = $(this).parent().children('.plan-max').val();
			var y = $(this).parent().children('.plan-min').val();
			var Unit=1;
			if(typeof(v)=='string'){
			    if(v.match(/k/i)){Unit=1000;} else if(v.match(/h/i)){Unit=10000;} else if(v.match(/a/i)){Unit=100;}
			    v=v.replace(/[^-0-9.]+/g,'');
			    w=w.replace(/[^-0-9.]+/g,'');
			    y=y.replace(/[^-0-9.]+/g,'');
			    if(mysplit=v.match(/^([0-9]*)k?h?a?[ ]*-[ ]*([0-9]*)k?h?a?[ ]*$/)){
				y=mysplit[1];
				w=mysplit[2];
			    }
			    if($.isNumeric(y)){yn=parseInt(y)*Unit;y=yn.toString();}else{y='';}
			    if($.isNumeric(w)){wn=parseInt(w)*Unit;w=wn.toString();}else{w='';}
			    var t;if(y&&w&&yn>wn&&(t=fixrange(y,w))){y=t[0];w=t[1]}
			    $(this).parent().children('.plan-min').value=y;
			    $(this).parent().children('.plan-max').value=w;
			}
			var pak = '';
			var cmd = '';
			if($('#APP'+x).length){
				$('#APP'+x).siblings('.remove').click();
			}
			if(w.length>0||y.length>0){ pak = y+'-'+w;
						    cmd = (y.length>0? y +'<=' +x +(w.length>0?' and ':''):'')
							 +(w.length>0? x +'<=' +w :'');
				APP.workers.insertSpacer(x,cmd,$(this).parent().siblings('span').text(),pak,$(this).parents('.quadbar-spacer').data('cat'),'oldput');
				$(this).parent().children('.plan-max').val(w);
				$(this).parent().children('.plan-min').val(y);
					
				}
				}else{
					sibs.find('.taken').click();
				}
				$(this).blur();
				$('#requestbtn').click();
			}		//End Key 13 Return
		});//Keydown quadbar-spacerinp
		$('#APP-inpcase').on('click','#closebiens',function(e){
			e.stopPropagation();
			$('.plan-submenu').addClass('hidden');
		});//Click #closebiens
		$('#APP-inpcase').on('mouseover','#closebiens',function(e){
			e.stopPropagation();
		});//mouseover #closebiens
		$('#APP-inpcase').on('mouseover','.plan-submenu table tr',function(){
			$('.taken').removeClass('taken');
			$(this).addClass('taken');
		}).on('mouseout',function(){
			$('.taken').removeClass('taken');
		});//mouseover add/remove taken
		$('#APP-inpcase').on('click','.plan-submenu table tr',function(e){
			if(!e.target.className.match('myclick')){
				e.preventDefault();
				e.stopPropagation();
				var x = $(this).parents('table');
				var spacer = false;
				if($(this).parents('.spacer').length){
					spacer = true;
				}
				if(x.data('cmdname')=="ville"){
					//var vv = $(this).parents('.plan-submenu').siblings('input').val().split(" ");
					var p = APP.villeResult[$(this).index()];
					//vv[vv.length-1]=p.PAK;//).replace(/[\x28][^\x29]*[\x29]/,'');
				}
				if($('#APP'+x.data('cmdname')).length&&!spacer){
					if(x.data('cmdname')=="BIENS"){
						$('#APPBIENS').parents('.spacer').remove();
						$('#plan-BIENS .quadbar-spacerinp').val('').removeClass('filled');
						if($(this).hasClass('plan-submenu-Tout')){
							$('.reserved').removeClass('reserved');
						}
						//$('#plan-BIENS').removeClass('translu');
					}else{
						$('#APP'+x.data('cmdname')).siblings('.remove').click();
					}
				}
				if(!$(this).hasClass('plan-submenu-Tout')){
					if(x.data('cmdname')=="ville"){
						$(this).parents('.plan-submenu').siblings('input').val(p.PAK);
						$('#plan-ville-textarea').val(p.PAK);
						var vval = $('#plan-ville input').val();
						//APP.workers.insertSpacer('ville','ville=<"'+ vval +'"',$('#plan-ville .plan-submenu table').data('title'),vval,$('#plan-ville .plan-submenu table').data('cat'),'oldput');
						APP.workers.insertSpacer('ville',p.cmd,$('#plan-ville').find('.plan-submenu table').data('title'),p.PAK,$('#plan-ville').find('.plan-submenu table').data('cat'),'oldput');
						$('#plan-ville').find('tr').remove();
						$('.plan-submenu').addClass('hidden');
					}else if(x.data('cmdname')=="BIENS"){
						$(this).toggleClass('reserved');
						if(spacer){$('#plan-BIENS').find('.plan-submenu tr').removeClass('reserved');$(this).parents('.plan-submenu').siblings('input').val('');}
						var p='nat in(';
						var q=Array();
						var studio = '';
						$(this).parent().children('.reserved').each(function(){
							if(spacer){$('#plan-BIENS .plan-submenu tr').eq($(this).index()).addClass('reserved')}
							$(this).parents('.plan-submenu').siblings('input').val($(this).parents('.plan-submenu').siblings('input').val()+' '+$(this).data('pak'))
							if($(this).data('pdata')=='studio'){
								studio=' and p=1';
								q.push('"appt"');
							}else{
								q.push('"'+$(this).data('pdata')+'"');
							}
						});
						q=q.join(',');
						p+=(q+')'+studio);
						$('#truvalBIENS').text(p);
						if($('.reserved').length){
							if(spacer){
								$('#plan-BIENS').find('input').val($(this).parents('.plan-submenu').siblings('input').val());
							}else{
								APP.workers.insertSpacer('BIENS',p,'Biens:',$(this).parents('.plan-submenu').siblings('input').val(),'003','oldput');
							}
						}
					}else{
						if(spacer){
							$('#truval'+x.data('cmdname')).text(htmlDecode($(this).data('pdata')));
							$('#plan-'+x.data('cmdname')).find('input').val($(this).data('pak'));
						}
						else{
							APP.workers.insertSpacer(x.data('cmdname'),htmlDecode($(this).data('pdata')),x.data('title'),htmlDecode($(this).data('pak')),x.data('cat'),'oldput');
						}
						$(this).parents('.plan-submenu').siblings('input').val($(this).data('pak'));
					}
				}
			}
			if(x.data('cmdname')!="BIENS"){
				$('.plan-submenu').addClass('hidden');
			}
			if(spacer){
				var fontspecs = {
					fontsize:$('.spacerinp').css('font-size'),
					fontfamily:$('.spacerinp').css('font-family'),
					fontweight:$('.spacerinp').css('font-weight')
				};
				$('#APP'+x.data('cmdname')).width(APP.workers.measureText($('#APP'+x.data('cmdname')).val(),fontspecs)+20);
			}
			/*if(x.data('cmdname')!="BIENS"&&x.data('cmdname')!="ville"){
				if(x.data('cmdname')=="an"){
					$('#plan-asr input').focus();
					console.log('asr focus');
				}else{
					var m = $(this).parents('td').next().find('.quadbar-spacerinp');
					m.hasClass('plan-max')?m.siblings('plan-min').focus():m.focus();
				}
			}*/
		});//click submenu tr to add spacer
		$('#APP-inpcase').on('focus','input',function(){
			$('.plan-submenu').addClass('hidden');
			if($(this).parents('.quadbar-spacer').attr('id')!="plan-ville"){
				$(this).siblings('.plan-submenu').removeClass('hidden');
				/*$('body').on('click',function submenuhide(e){
					if(!($(e.target).hasClass('plan-submenu'))&&!($(e.target).parents().hasClass('plan-submenu'))&&!($(e.target).hasClass('quadbar-spacerinp'))){
						$('.plan-submenu').addClass('hidden');
						$('body').off('click',submenuhide);
					}
				});*/
			}
		});//show/hide submenu on quadbar input focus
		$('#APP-inpcase').on('change','.plan-min, .plan-max',function(){
			var x = $(this).parents('.quadbar-spacer').attr('id').replace('plan-','');
			var v = $(this).val();
			var w = $(this).parent().children('.plan-max').val();
			var y = $(this).parent().children('.plan-min').val();
			var Unit=1;
			if(typeof(v)=='string'){
			    if(w.match(/k/i)||y.match(/k/i)){Unit=1000;}
			    else if(w.match(/h/i)||y.match(/h/i)){Unit=10000;}
			    else if(w.match(/a/i)||y.match(/a/i)){Unit=100;}
			    v=v.replace(/[^-0-9.]+/g,'');
			    w=w.replace(/[^-0-9.]+/g,'');
			    y=y.replace(/[^-0-9.]+/g,'');
			    if(mysplit=v.match(/^([0-9]*)k?h?a?[ ]*-[ ]*([0-9]*)k?h?a?[ ]*$/)){
				y=mysplit[1];
				w=mysplit[2];
				if($(this).hasClass('plan-min')){v=y}else{v=w}
			    }
			    if($.isNumeric(y)){yn=parseInt(y)*Unit;y=yn.toString();}else{y='';}
			    if($.isNumeric(w)){wn=parseInt(w)*Unit;w=wn.toString();}else{w='';}
			    var t;if(y&&w&&yn>wn&&(t=fixrange(y,w))){y=t[0];w=t[1]}
			    $(this).parent().children('.plan-min').value=y;
			    $(this).parent().children('.plan-max').value=w;
			}
			
			var pak = '';
			var cmd = '';
			if($('#APP'+x).length){
				$('#APP'+x).siblings('.remove').click();
			}
			if(w.length>0||y.length>0){
				//if($(this).hasClass('plan-min')){
			//		if(w.length&&$.isNumeric(w)){
						pak = y+'-'+w;
						cmd =	 (y.length>0? y +'<=' +x +(w.length>0?' and ':''):'')
							+(w.length>0? x +'<=' +w :'')+(y.length>0&&x=="et"?' and et!=126':'');
			//		}else{
			//			pak = y + '+';
			//			cmd = v + '<=' + x;
			//		}
			//	}else{
			//		if(y.length&&$.isNumeric(y)){
			//			pak = y + '-' + v;
			//			cmd = ''+y+'<='+x+' and '+x+'<='+ v;
			//		}else{
			//			pak = v+'-';
			//			cmd = ''+v+'<='+x+'';
			//		}
			//	}
				APP.workers.insertSpacer(x,cmd,$(this).parent().siblings('span').text(),pak,$(this).parents('.quadbar-spacer').data('cat'),'oldput');
				$(this).parent().children('.plan-max').val(w);
				$(this).parent().children('.plan-min').val(y);
			}
		});//changing ranges
		$('#APP-inpcase').on('change','#plan-pr3 input',function(){
			var n = $(this).val();
			var m = n.replace(/[^0-9\x2B]/g,'');
			if($('#APPpr3').length){
				$('#APPpr3').siblings('.remove').click();
			}
			if(m.length>4){
				APP.workers.insertSpacer('pr3','pr3='+m,'Téléphone:',m,'001','oldput');
				$(this).val(m);
			}else{
				if($(this).val()!=""){
					$(this).removeClass('filled').addClass('invalid-page');
				}
			}
		});//#plan-pr3 input
		$('#APP-inpcase').on('change','#plan-date input',function(){
			var m = $(this).val();
			if($('#APPdate').length){
				$('#APPdate').siblings('.remove').click();
			}
			if(m.length>0){
				APP.workers.insertSpacer('date',m+'<=date','Depuis:',m,'001','oldput');
			}
		});//#plan-date input
		$('#APP-inpcase').on('change','#plan-MOT input',function(){
			var m = $(this).val();
			if(m.match(/[\x29]$/)){
				m = m + '"';
				if(m.replace(/[^"]/g,'').length % 2 != 0){
					m = '"' + m;
				}
			}
			if($('#APPMOT').length){
				$('#APPMOT').siblings('.remove').click();
			}
			if(m.length>0){
				APP.workers.insertSpacer('MOT',' MOT="'+m+'"','Mots:',m,'001','oldput');
				$(this).val(m);
			}
		});//#plan-MOT input
		$('#APP-inpcase').on('blur','#plan-ville-textarea',function(e){
			var thisval = $('#plan-ville-textarea').val();
			if(thisval==""){
				$('#APPville').siblings('.remove').click();
			}
			var thisval1 = thisval.replace(/([\x28][^\x29]*[\x29])/,'');
			if(!$('#APPville').length&&$(this).val()!=""){
				APP.workers.insertSpacer('ville','ville=<"'+thisval1+'"',$('#plan-ville .plan-submenu table').data('title'),thisval,$('#plan-ville .plan-submenu table').data('cat'),'oldput');
			}
		});//change #plan-ville input add spacer*/
		$('#APP-inpcase').on('click','.quadbar-spacer',function(e){
			if(!($(e.target).is('input')||$(e.target).is('textarea')||$(e.target).parents().is('.plan-submenu'))){
				if($(e.target).is('#plan-an')||$(e.target).parents().is('#plan-an')){
					$('#plan-an input').focus();
				}else{
					$(this).find('input:first-of-type').focus();
				}
				//$(this).find('.quadbar-spacer:not(#plan-ville) .plan-submenu').removeClass('hidden');
			}
		});
		$('#APP-inpcase').on('focus','#plan-ville input',function(){
			$('#plan-ville-textarea').parent().removeClass('nodisplay').css('height',$('#llastplace').height()-10);
			$('#plan-ville-textarea').css('height',$('#plan-ville-textarea').parent().height()-20);
			$('#plan-ville-textarea').focus().putCursorAtEnd();
		});
		$('body').on('click',function hidetxtcse(e){
			if(!($(e.target).parents('#plan-ville').length||$(e.target).is('.remove'))){
				$('#plan-ville-textarea').parent().addClass('nodisplay');
			}
		});
		//--------------------------------------------------------------------------------------------------------------
		//MISCELLANEOUS LISTENERS FOR THE RESULT PAGE-------------------------------------------------------------------
		$('#resultats').on('click','td[class^="classbloctel"] a',function(e){
		var href=$(this).attr('href');
		if(href.match(/click[.]p/)){
			e.preventDefault();
			href=href.replace(/sid=[^&]*/,'').replace(/click/,'clic');
			if(window.location.href.match(/https/)){
				href=href.replace(/https?/,"https");
			}
			var tpos = $(this).position();
			var tposh = tpos.top - 200;
			$('#bloctel-dia-conf').attr('href',href);
			$('#bloctel-dia').css({
				"left":tpos.left,
				"top": tposh
			});
			$('#bloctel-dia').removeClass('nodisplay');
		}
	});
		$('#APP-gotopg').focus(function(){
			this.setSelectionRange(0,$(this).val().length);
		});
		window.caddyarray=[];
		/*$('body').on('click','#resultats td',function(event){
			event.preventDefault();
			window.caddyarray.push($(event.target).parent('tr').html());
				var v = function(){
						var intercontent='<table>';
						for(i=0;i<window.caddyarray.length;i++){
							intercontent += ('<tr>'+window.caddyarray[i]+'</tr>');
						}
						intercontent += '</table>';
						if(typeof(intercontent)=="string"){return intercontent;}else{
							return intercontent.toString();
						};
					}
				window.caddymodal=new Modal({
					content: v()
				});
			$('#caddyshack').removeClass('nodisplay');
		});*/
		/*$('#caddyshack').click(function() {
			window.caddymodal.open();
		});*/
		$(document).on('DOMMouseScroll mousewheel', '.Scrollable', function(ev) {
			var $this = $(this),
				scrollTop = this.scrollTop,
				scrollHeight = this.scrollHeight,
				height = $this.height(),
				delta = (ev.type == 'DOMMouseScroll' ?
					ev.originalEvent.detail * -40 :
					ev.originalEvent.wheelDelta),
				up = delta > 0;

			var prevent = function() {
				ev.stopPropagation();
				ev.preventDefault();
				ev.returnValue = false;
				return false;
			}

			if (!up && -delta > scrollHeight - height - scrollTop) {
				// Scrolling down, but this will take us past the bottom.
				$this.scrollTop(scrollHeight);
				return prevent();
			} else if (up && delta > scrollTop) {
				// Scrolling up, but this will take us past the top.
				$this.scrollTop(0);
				return prevent();
			}
		});//Prevent the scroll event from bubbling to the document from the autocomplete menu
		$('#requestbtn').click(function(){
			if($('.truval').length){
				APP.openurl=APP.workers.getOutput()[0];
			}else{
				APP.openurl=decodeURIComponent(window.uri1);
			}
			APP.workers.adCall("x",APP.openurl,1);
		});
		/*var inpxcsv = $('.xcsv select').val();
				if(inpxcsv!="0"){
					var p = new RegExp(/where=[^&]*&/);
					var m = inpxcsv.replace(p,'where='+encodeURIComponent(APP.openurl)+'&');
					var f = inpxcsv.match(/modefichier=([0-9])/i);
					$('#excel_iframe_selectim').remove();
					$('body').append('<iframe id="excel_iframe_selectim" style="display:none;"src='+m+'&modefichier='+f[1]+'"></iframe>');
				}else{*/
		$('#excel, #csv').click(function(){
			APP.openurl=APP.workers.getOutput()[0];
			var inpxcsv = $(this).data('lien');
			var p = new RegExp(/where=[^&]*&/);
			var m = inpxcsv.replace(p,'where='+encodeURIComponent(APP.openurl)+'&');
			var f = inpxcsv.match(/modefichier=([0-9])/i);
			$('#excel_iframe_selectim').remove();
			$('html').css('cursor','wait');
			$('body').append('<iframe id="excel_iframe_selectim" style="display:none;"src='+m+'&modefichier='+f[1]+'"></iframe>');
				$('html').css('cursor','initial');
		});
		$('#resultats').on('click','.abcd',function(event){
			event.preventDefault();
			//var tel=$(this).attr('href').match(/%3C([0-9]{2}[0-9]*)&:/);
			var tel = $(this).parents('tr').attr('id').replace('tr','');
			//APP.telnum=tel[1];tel=tel[1].split(' ').join('');
			APP.telnum="Téléphone";
			APP.openurl=encodeURIComponent('pr3=<'+tel);
			var telurl=encodeURIComponent('pr3=<'+tel);
			APP.workers.adCall('telclick',telurl,'1');
		});
		$('body').on('click','[data-toggle]',function(e){
			//e.stopPropagation();
			$('.toggled').not($(this)).removeClass('toggled');
			if($(this).hasClass('APP-highlight')){
				$(this).toggleClass('toggled');
			}
			var s = $(this).data('toggle');
			$('.stopprop').not(s).addClass('nodisplay').removeClass('stopprop');
			$(s).toggleClass('nodisplay');
			$(s).toggleClass('stopprop');
			if($(this).data('togglestate')=="0"){
				$(s).toggleClass('stopprop');
			}
		});//click [data-toggle]
		$('body').on('click',function tglfc(e){
			if(!$(e.target).hasClass('stopprop')&&!($(e.target).hasClass('toggle-ignore')||$(e.target).data('toggle')||$(e.target).parents().data('toggle'))){
				$('.stopprop').addClass('nodisplay').removeClass('stopprop');
				$('.toggled').removeClass('toggled');
				//$('body').off('click',tglfc);
			}
		});//click, tglefnc()
		$('body').on('click','.textex',function(){
			$(this).toggleClass('textextoggle');
			if($(this).hasClass('textextoggle')){
				$(this).parent().siblings('.noscroll2').css({'height':'auto','overflow':'auto'});
				$(this).text('[-]');
			}else{
				$(this).parent().siblings('.noscroll2').css({'height':'6em','overflow':'hidden'});
				$(this).text('[+]');
			}
		});//click textex
		$('body').on('click','.textexp',function() {
			var qq = $(this).parents('td').position().top - $(window).scrollTop();
			//$(this).toggleClass('toggled');
			//$('.noscroll2').toggleClass('expandall');
			//if($('.noscroll2').hasClass('expandall')) {
			if(typeof(APP.expanded)=='undefined'||APP.expanded==0) {
				APP.expanded = 1;
				//$(document).off('click','.noscroll2',APP.workers.noscroll2Function);			
				$('.noscroll2').css({ "height":"auto", "overflow":"auto" }); $('.textexp').text('[--]');
				$('.textex').addClass('nodisplay');
				$(window).scrollTop($(this).parent().position().top);
				var that = $(this);
				$(this).siblings('.noscroll2').children().css('background-color','#88B4E5');
				setTimeout(function(){
				that.siblings('.noscroll2').children().css('background-color','#FFF');
				},500);
				//$(window).scrollTop($(this).siblings('.noscroll2').position().top-40);
				//$(window).scrollTop($(window).scrollTop() + $(window).innerheight() / 2);
			}else {
				APP.expanded = 0;
				$('.noscroll2').css({
					"height":"6em",
					"overflow-y":"hidden"
				});
				$('.textex').removeClass('nodisplay');
				$('.textexp').text('[++]');
				//$(document).on('click','.noscroll2',APP.workers.noscroll2Function);
				//$(window).scrollTop($(this).siblings('.noscroll2').position().top-40);
				//$(window).scrollTop($(window).scrollTop() + $(window).innerheight() / 2);
			}
			$(window).scrollTop($(this).parents('td').position().top - qq);
		});//Expand announce details
		$('#APP-handlebar').click(function(){
			$(this).toggleClass('APP-useractive');
			APP.workers.handlebar();
		});
		$( window ).scroll(function() {
				if(window.detectmob()){return 0;}else{
		 		APP.workers.scrollFunction();
		 		}
    		});//Infinite scrolling function
    	$('.APP-caddie-menu li').click(function(e){
    		switch($(this).index()) {
    			case 0:
    				APP.workers.adCall('caddie',$(this).data('cmd'),1);
    				break;
    			case 1:
    				var lngcn = lng('Are you sure you want to empty your caddie?','En')+lng('Tem certeza de que deseja esvaziar o seu cart?','Pt')+lng('Êtes-vous sûr de vouloir vider votre caddie?','Fr');
    				var g = window.confirm(lngcn);
					if(g==true){
						APP.workers.adCall('videcaddie',APP.openurl,1);
					}
					break;
				case 2:
					APP.workers.adCall('notes',$(this).data('cmd'),1);
					break;
				case 3:
					e.stopPropagation();
					break;
				default:
					break;
    		}
    	});
    	$('.APP-caddie-menu li button').click(function() {
    		if($(this).siblings('input').val().length>0){
    			APP.workers.adCall('notes',$(this).parents('li').data('cmd')+$(this).siblings('input').val(),1);
    		}else{
    			APP.workers.adCall('notes',$(this).parents('li').data('cmd').replace(/and[ ]?NOTA[=].*/,''),1);
    		}
    	});
    	$('.APP-caddie-menu input').keydown(function(e){
    		if(e.which==13){
    			if($(this).val().length>0){
    				APP.workers.adCall('notes',$(this).parents('li').data('cmd')+$(this).val(),1);
    			}else{
    				APP.workers.adCall('notes',$(this).parents('li').data('cmd').replace(/and[ ]?NOTA[=].*/,''),1);
    			}
    		}
    	});
		//$('.APP-caddie-menu li:first-of-type').click(function(){
			/*$('.spacer').remove();
			APP.workers.clearPlan();
			var x = $(this).data('PAK').split(':');
			var y = lng('Caddie:','Fr')+lng('Cart','En')+lng('Carrinho','Pt');
			if(x.length>1){
				y = x[0]+': ';
				x = x[1];
			}else{
				x = $(this).data('PAK');
			}
			APP.workers.insertSpacer('NOTA','NOTES',y,x,'001','x');*/
			//APP.workers.adCall('caddie',$(this).data('cmd'),1);
		//});
		$('body').on('click','.telexcel, .telcsv',function(){
			var lg = 'pt';
			if(top.selectim.LANG){lg=top.selectim.LANG.toLowerCase();}
			var t = '4';
			if($(this).attr('id')=="telcsv"){
				t = '3';
			}
			var m = '/?x=1024&y=768&z=0&MAC=0&ass2calm=0&gotck=1&recec=0&lg='+lg+'&inframe=1&wheresi=245&modefichier='+t+'&where='+encodeURIComponent($(this).data('cmd'));
			$('#excel_iframe_selectim').remove();
			$('html').css('cursor','wait');
			$('body').append('<iframe id="excel_iframe_selectim" style="display:none;"src="'+m+'"></iframe>');
				$('html').css('cursor','initial');
		});//Click telexcel and telcsv print to those formats
		/*$('.APP-caddie-menu li:nth-child(2)').click(function(){
			var g = window.confirm('Are you sure you want to empty your caddie?');
			if(g==true){
				APP.workers.adCall('videcaddie',APP.openurl,1);
			}
		});*/
		$('#see_cart, #see_bin').click(function(event){
			event.preventDefault();
			var fromwhere="bin";
			if($(this).attr('id')=="see_cart"){fromwhere="caddie";}
			var p = $(this).attr('href').match(/where=([^&']*)/);
			APP.workers.adCall(fromwhere,p[1].replace('where=',''),1);
		});
		$('#resultats').on('click','.colspanscroll',function(){
			APP.workers.adCall("scroll",APP.openurl,APP.currentpage+1);
		});//click colspanscroll, go to next page
		$('.textbox').click(function(e){
			if(e.target.className=="textbox"||e.target.id=="APP-inputcase"){
				APP.input.focus();
			}
		});
		$('#resultats').on('click','tr:first-child td a',function(e){
			e.preventDefault();
			var m = $(this).attr('href').match(/(order=[^']*)'/);
			if(m.length>1){
				APP.orderwhere = +'&qtri=&'+m[1];
				APP.workers.adCall('order',APP.openurl,'1');
			}
		});//click tr first child order results
		//---------------------------------------------------------------------------------------------------------------
		//Main search input event listeners-----------------------------------------------------------------------------
		$('#APP-clear-all').click(function(){
			APP.workers.clearPlan();
			APP.input.focus();
		});
		$('#dynputdiv').on('click','#topopagina',function(){
			if($('#APP-handlebar').hasClass('APP-toggled')){
				APP.workers.handlebar();
			}
		});//click topopagina
		$('#dynputdiv').on('click','.APP-locbox table tr',function(event) {
				if(!event.target.className.match('myclick')){
				var data = APP.debugJSON;
				if($("#" + APP.source).val() == '') {
					return 0;
				}
				var indexer = $(this).index();
				var bccbcbcbc = '';
				if($(this).children('td:first-of-type').children("b:first-of-type").length){
					bccbcbcbc=$(this).children('td:first-of-type').children("b:first-of-type").html();
				}
				var cm = data[indexer].cmdname;
				if(cm=="DISCON"&&data[indexer].cmd=="1"){return 0;}
				var m = data[indexer].PAK;
				if($("#" + APP.source).hasClass("spacerinp")) {
					$("#" + APP.source).siblings('.remove').click();
				}
				else {
					$("#APP-input").val("");
				}
					$('#APP' + cm).siblings('.remove').click();
					APP.workers.insertSpacer(cm,data[indexer].cmd,bccbcbcbc,data[indexer].PAK,data[indexer].cat,'#APP-input');
				/*var n = (m.length<100?m.length:20);
				var fontspecs= {
					fontsize:$('.spacerinp').css('font-size'),
					fontfamily:$('.spacerinp').css('font-family'),
					fontweight:$('.spacerinp').css('font-weight')
				}
				$('#APP' + cm).attr("size",n);
				if(m.length >= 40){
					$('#APP' + cm).parent('.spacer').addClass('spacer_expand');
					$('#APP' + cm).attr('title',m);
					$('<b class="elipse" style="font-size:large;">...</b>').insertAfter($('#APP' + cm));
				}else{
					$('#APP' + cm).parent('.spacer').removeClass('spacer_expand');	
				}
				$('#APP' + cm).css("width", APP.workers.measureText(m,fontspecs));*/
				APP.source = "APP-input";
				$(".APP-menu").addClass("hidden");
				$(".APP-locbox table tr").remove();
				$('#ghost').val('');
			}
		});//Click tr add item from suggestion list
		$('#APP-inpcase').on('click, dblclick','#APP-input',function(event) {
			event.stopPropagation();
		});
		$(".textbox").on('keyup', '.spacerinp', function(event) {
			if(!APP.workers.validateKey(event.which)){return false;}
			$(this).removeClass('invalid-page');
			var p = $(this).val();
			if($(this).is('[id^="APPindex"')){
				$(this).siblings('.truval').text(p);
			}
			var m = $(this).siblings('.plan-submenu').find('.taken');
			switch(event.which) {
				case 13:
					if(m.length){
						m.click();
						$('#requestbtn').click();
					}else{
						var appmenu = $(".APP-menu table tr");
						if(appmenu.length > 0) {
							//APP.source = $(this).attr("id");
							if($('.taken').length) {
								$('.taken').click();
							}else {
								$(".APP-menu table tr:first-child").click();
							}
							$('#requestbtn').click();
						}else{
							$('#requestbtn').click();
						}
					}
					break;
				default:
					if($(this).is('#APPville')){
						var tempo=300;tempofirst=200;var now=new Date().getTime();
											if(typeof(window.mytime)!=='undefined'){
												if(window.mytime){
													window.clearTimeout(window.mytime);
													window.mytime=0;
													window.mybackuptime=0;
												} else if(window.mybackuptime){
													window.clearTimeout(window.mybackuptime);
													window.mybackuptime=0;
							} else{
							if(	now-window.mylasttime>2*tempo ){tempo=tempofirst;}
							}
											}
											else{        
							if(typeof(window.mybackuptime)==='undefined'||now-window.mylasttime>2*tempo ){tempo=tempofirst;}
						}
						window.source = $(this);
						APP.timerstarted = true;
								window.mytime = window.setTimeout(function() { APP.workers.keyupFunction(source); },tempo);
								window.mylasttime=now;
								window.mybackuptime=window.mytime;
					}
					break;
			}
		});//Keyup event listener for search term mini-input boxes, similar to main input listener
		$(".textbox").click(function(event) {
			var target = $(event.target);
			
			if(!(target.is('.spacer_textarea')||target.parents('.spacer_textarea').length)) {
				$('.spacer_textarea').addClass('nodisplay');
				$('.spacerinp').removeClass('nodisplay');
			}
		});//Clicking on the main input box mask focuses on actual hidden input
		$(".textbox").dblclick(function() {
			//if(!($('#APP-input, .spacer').is(':hover'))) {
				if (APP.input.setSelectionRange) {
					APP.input.setSelectionRange(0, APP.input.val().length);
				}else {
					APP.input.select();
				}
			//}
		});//Doubleclick in the main input box mask to select all
		$(".textbox").on('keydown', '.spacerinp', function(event) {
			var where = false;
			if($(this).is('#APPville')){
				where = $('.APP-menu tr');
			}
			if($(this).siblings('.plan-submenu').length){
				where = $(this).siblings('.plan-submenu').find('tr');
			}
			if(where){
				APP.pageselect(event,where);
			}
			if(event.which == 37) {
				var x = $(this).getCursorPosition();
				if(($(this).parent().prev().hasClass('spacer')||$(this).parent().prev().is('br')) && x === 0) {
						if($(this).parent().prev().is('br')){
							$(this).parent().prev().prev().children('input').putCursorAtEnd();
						}
						$(this).parent().prev().children('input').putCursorAtEnd();
						var that = $(this);
						if($(this).get(0).setSelectionRange) {
							setTimeout(function() {
								that.parent().prev().children('input').focus().get(0).setSelectionRange(that.parent().prev().children('input').val().length,that.parent().prev().children('input').val().length);
							},50);
							APP.prevsspacer = 0;
						}else if($(this).get(0).createTextRange) {
							setTimeout(function() {
								var part = that.parent().prev().children('input').get(0).createTextRange();
           				 		part.move("character", that.parent().prev().children('input').val().length);
            					part.select();
            				},50);
							APP.prevsspacer = 1;
						}
				}
			}
			if(event.which == 9) {
				if($(this).val()!==""){
					//MINMAX Here treat the case when Range PAK was modified but not CMD (bbecause of no click on autocomplete proposal)
					if($('.taken').length) {
						event.preventDefault();
						$('.taken').click();
					}/*else {
						APP.workers.keyupFunction($(this));
						setTimeout(function() {
							$(".APP-locbox").find('.taken').click();
							$('.APP-locbox').find('tr').remove();
							$('.APP-locbox').addClass('hidden');
						},100);
					}*/
				}else{
					$(this).parent().remove();
				}
			}	
			if(event.which == 39) {
				var x = $(this).getCursorPosition();
				var splitthis = $(this).val().split("");
				if($(this).parent().next().hasClass('spacer') && x === splitthis.length) {
					//$(this).parent().next().children('input').focus();
					var that = $(this);
					if($(this).get(0).setSelectionRange) {
						setTimeout(function() {
							that.parent().next().children('input').focus().get(0).setSelectionRange(0,0);
						},50);
					}else if($(this).get(0).createTextRange) {
						
						setTimeout(function() {
						 var part = that.parent().next().children('input').get(0).createTextRange();
           				 part.move("character", 0);
            			part.select();
            			},50);
					}else {
						 $(this).parent().next().children('input').focus();
					}
				}else if($(this).parent().next().attr("id") == "APP-inputcase" && x === splitthis.length) {
					//var that = $(this);
					if($(this).get(0).setSelectionRange) {
						setTimeout(function() {
							//that.parent().next().focus().get(0).setSelectionRange(0,0);
							$('#APP-input').focus().get(0).setSelectionRange(0,0);
						},50);
					}else if($(this).get(0).createTextRange) {
						
						setTimeout(function() {
						 //var part = that.parent().next().get(0).createTextRange();
						  var part = $('#APP-input').get(0).createTextRange();
           				 part.move("character", 0);
            			part.select();
            			},50);
					}else {
						 $('#APP-input').focus();
					}
				}
				$('.APP-locbox').addClass('hidden');
			}
		});//Keydown event listener for search term mini-input boxes, similar to main input listener
		$("#APP-input").keyup(function(event) {
			if(!APP.workers.validateKey(event.which)){return false;}
			if(parseInt(event.which)!==40&&parseInt(event.which)!==38){$('#ghost').val('');}
			APP.returncount = 0;
			var p = APP.input.val();
			if($(".spacer").length > 0 || p !== "") {
				$("#placeholdertext").addClass("hidden");
			}else {
				$("#placeholdertext").removeClass("hidden");
			}
			/*if($(".spacer").length > 0) {
				$("#requestbtn").attr("disabled", false);
			}else {
				$("#requestbtn").attr("disabled", true);
			}*/
			if(p == "") {
				$(".APP-menu").addClass("hidden");
			}
			if(escapeRegExp(p).match(/^[ ]*$/)){APP.input.val(p.replace(" ",""));}
			switch(event.which) {
				case 27:
					$(".APP-menu").addClass("hidden");
					$(".APP-menu li").removeClass("taken");
					break;
				case 13:
					//var appmenu = $(".APP-menu table tr");
					var appmenu = $('.APP-locbox .taken');
					if(appmenu.length > 0) {
						APP.source = $(this).attr("id");
						/*if($('.taken').length) {
							$('.taken').click();
							APP.input.focus();
						}else {*/
						//	$(".APP-menu table tr:first-child").click();
						$('.APP-locbox .taken').click();
						//}
					}
					$('#requestbtn').click();
					break;
				default:
					//var tempo=350;tempofirst=200;var now=new Date().getTime();
					var tempo=150;tempofirst=50;var now=new Date().getTime();
                                        if(typeof(window.mytime)!=='undefined'){
                                            if(window.mytime){
                                                window.clearTimeout(window.mytime);
                                                window.mytime=0;
                                                window.mybackuptime=0;
                                            } else if(window.mybackuptime){
                                                window.clearTimeout(window.mybackuptime);
                                                window.mybackuptime=0;
					    } else{
						if(	now-window.mylasttime>2*tempo ){tempo=tempofirst;}
					    }
                                        }
                                        else{        
						if(typeof(window.mybackuptime)==='undefined'||now-window.mylasttime>2*tempo ){tempo=tempofirst;}
					}

					if(APP.suggeststatus == 1) {
						window.source = $(this);
						var source = $(this);
						if($('#APP-input').val().length == 1) {
							tempo=tempofirst;//APP.workers.keyupFunction(source);
						} 
							APP.timerstarted = true;
							window.mytime = window.setTimeout(function() { APP.workers.keyupFunction(source); },tempo);
							window.mylasttime=now;
							window.mybackuptime=window.mytime;
						
					}
					break;
			}
		});//Central input keyup event listener
		APP.input.keydown(function(event) {
			$('#APP-assistmenu').addClass('hidden');
			if(typeof window.mytime !== 'undefined' && window.mytime !== 0){
				clearTimeout(window.mytime);
				window.mytime = 0;
			}
			APP.suggeststatus = 1;
			var ignored = [16,17,18,19,20,27,28,29,30,31,32,33,34,35,36,37,38,39,40,45,91,92,93,112,113,114,115,116,117,118,119,120,121,122,123,144,145];
			for(x=0;x<ignored.length;x++){
				if(event.which == ignored[x]) {
					APP.suggeststatus = 0;
				}
			}
			APP.pageselect(event,$('.APP-menu tr'));
			APP.returncount = 0;
			var p = APP.input.val();
			var q = $("#ghost").val();
			var p = APP.input.val();
			/*if($(".spacer").length > 0) {
				$("#requestbtn").attr("disabled", false);
			}else {
				$("#requestbtn").attr("disabled", true);
			}*/
			if(p == "") {
				$(".APP-menu").addClass("hidden");
			}
			if(event.which != 32){window.spacetrigger=0;}
			if(event.which == 13) {
				event.preventDefault();
				/*if(APP.input.val() !== "") {
					if($(".taken").length == 1) {
						$(".taken").click();
						$('.taken').removeClass('taken');
						APP.returncount = 1;
					}
				}*/
			}
			if(event.which == 37) {
				var x = APP.input.getCursorPosition();
				if(($('#APP-inputcase').prev().hasClass('spacer')||$('#APP-inputcase').prev().is('br')) && x === 0) {
					if($('#APP-inputcase').prev().is('br')){
						$(this).parent().prev().prev().children('input').putCursorAtEnd();
					}
					$(this).parent().prev().children('input').putCursorAtEnd();
					var that = $(this);
					if($(this).get(0).setSelectionRange) {
						setTimeout(function() {
							that.parent().prev().children('input').focus().get(0).setSelectionRange(that.parent().prev().children('input').val().length,that.parent().prev().children('input').val().length);
						},50);
						APP.prevsspacer = 0;
					}else if($(this).get(0).createTextRange) {
						setTimeout(function() {
							var part = that.parent().prev().children('input').get(0).createTextRange();
							part.move("character", that.parent().prev().children('input').val().length);
							part.select();
						},50);
						APP.prevsspacer = 1;
					}
				}
			}
			if(event.which == 32 && APP.input.val().match(/^([a-zA-Zà-ÿÀ-Ü]{1,2}|\u20AC)[ ]?[0-9]+|^....[^ ]/)){window.spacetrigger=1;}
			if(event.which == 9||event.which == 32) {// && $(this).val().match(/^[fF][0-9]$/)
				if(event.which== 9){event.preventDefault();}
				//if(window.ijuststartedaget){
				//}else{				
					//APP.workers.keyupFunction($(this));
					if(!window.ijustfinishedaget == $(this).val()){///^F[0-9]$/i)
						APP.workers.keyupFunction($(this));
					}
					//$(".taken").click();
					//APP.input.focus();
					//$('.APP-menu').addClass('hidden');
					
			//	}
				if(event.which==9){event.stopPropagation();$(".APP-locbox .taken").click();setTimeout(function(){$('.APP-menu').addClass('hidden');},50);}
			}
			if(event.which == 8) {
				if(p == ""&&$('#APP-inputcase').prev().length) {
					if($('#APP-inputcase').prev().is('br')){
						$('#APP-inputcase').prev().remove();
					}else{
						APP.workers.removePakVal($("#APP-inputcase").prev().children('.spacerinp').attr('id'));
					}
				}
			}
		});//Central input keydown event listener
		$("#dynputdiv").on('click','.remove', function() {
			/*if($(this).parent(".spacer").prev().is('br')) {
				$(this).parent('.spacer').prev().remove();
			}*/
			$('.textbox br').remove();
			APP.workers.removePakVal($(this).siblings('.spacerinp').attr('id'));
			setTimeout("APP.workers.respace();",10);
			APP.input.focus();
		}); //Click the X button to remove a search term from the list
		$('.APP-locbox').on('mouseover','tr',APP.workers.locmove);//Mouseover add Taken
		$('.textbox').on('focus','.spacerinp_expand',function(){
			$(this).addClass('nodisplay');
			$(this).siblings('.spacer_textarea').removeClass('nodisplay')
			$(this).siblings('.spacer_textarea').children('textarea').val($(this).val()).focus().putCursorAtEnd();
		});//focus spacerinp_expand
		$('.textbox').on('keydown','textarea',function(event){
			APP.pageselect(event,$('.APP-menu tr'));
			if(event.which==9){
				event.preventDefault();
				var n = $('.APP-locbox').find('.taken');
				if(n.length){
					n.click();
				}else{
					$(this).parents('.spacer').next().find('.spacerinp').focus();
					$(this).parents('.spacer_textarea').addClass('nodisplay');
					$(this).parents('.spacer_textarea').siblings('.spacerinp').removeClass('nodisplay');
				}
			}
			if(event.which==13){
				event.preventDefault();
			}
		});//keydown textarea
		$('.textbox').on('keyup','textarea',function(event){
			if(!APP.workers.validateKey(event.which)){return false;}
			var x = $(this).parent().siblings('.spacerinp');
			x.val($(this).val());
			if($(this).parents('.spacer_textarea').siblings('#APPville').length){
				$('#truvalville').text('ville=<"'+ $(this).val().replace(/([\x28][^\x29]*[\x29])/,'')+'"');
				$('#plan-ville input').val($(this).val());
				$('#plan-ville-textarea').val($(this).val());
			}
			if(event.which==13){
				if($(this).val()!==""){
					if($('.APP-menu .taken').length) {
						$('.APP-menu .taken').click();
					}
					$('#requestbtn').click();
					$(this).parents('.spacer_textarea').addClass('nodisplay');
					x.removeClass('nodisplay');
				}
			}else{
				APP.workers.keyupFunction($(this).parent().siblings('.spacerinp'));
			}
		});//keyup textarea
		/*$('.textbox').on('blur','textarea',function(){
			$(this).parent().addClass('nodisplay');
			$(this).parent().siblings('.spacerinp').removeClass('nodisplay');
			$('.APP-locbox').addClass('hidden');
		});*/
		$('.textbox').on('click','.spacer_textarea',function(event){
			event.stopPropagation();
		});//click .spacer_textarea
		$('.textbox').on('click','.spacerinp-textarea-toggle',function(){
			var m = $(this).parent('.spacer_textarea');
			m.siblings('.spacerinp').removeClass('nodisplay');
			m.addClass('nodisplay');
		});//click .spacerinp-textarea-toggle
		$('.textbox').on('dblclick','.spacer_textarea',function(event){
			event.stopPropagation();
		});//dblclick spacer_textarea
		$('.textbox').on('change','#APPpr3',function(){
			var m = $(this).val().replace(/[^0-9\x2B]/g,'');
			$('#plan-pr3 input').val(m);
			$(this).siblings('.truval').text('pr3='+m);
			if(m.length<4&&m!=""){
				$(this).addClass('invalid-page');
				$('#plan-pr3 input').removeClass('invalid-page');
				$('#plan-pr3 input').addClass('invalid-page');
			}
		});//change ##APPpr3'
		$('.textbox').on('change','#APPprix,#APPet,#APPM2,#APPs,#APPp,#APPARE,#APPja,#APPch',function(){
			var w='';
			var y='';
			var x = $(this).attr('id').replace('APP','');
			var v = $(this).val();
			//var w = $(this).parent().children('.plan-max').val();
			//var y = $(this).parent().children('.plan-min').val();
			var Unit=1;
			if(typeof(v)=='string'){
			    if(v.match(/k/i)){Unit=1000;}
			    else if(v.match(/h/i)){Unit=10000;}
			    else if(v.match(/a/i)){Unit=100;}
			    v=v.replace(/[^-0-9.]+/g,'');
			    if(v.match('-')){
					if(mysplit=v.match(/^([0-9]*)k?h?a?[ ]*-[ ]*([0-9]*)k?h?a?[ ]*$/)){
					if(mysplit.length>2){
						y=mysplit[1];
					}
					w=mysplit[2];
					//if($(this).hasClass('plan-min')){v=y}else{v=w}
					}
					if($.isNumeric(y)){yn=parseInt(y)*Unit;y=yn.toString();}else{y='';}
					if($.isNumeric(w)){wn=parseInt(w)*Unit;w=wn.toString();}else{w='';}
					var t;if(y&&w&&yn>wn&&(t=fixrange(y,w))){
						y=t[0];w=t[1];
						$(this).val(t[0]+'-'+t[1]);
						var re=APP.workers.measureText($(this).val());
						$(this).width(re+20);
					}
					$('#plan-'+x).find('.plan-min').val(y).addClass('filled');
					$('#plan-'+x).find('.plan-max').val(w).addClass('filled');
			    }else{
			    	if($.isNumeric(v)){ee = parseInt(v)*Unit;y=ee.toString();}else{y='';}
			    	if(x=="prix"||x=="M2"||x=="ARE"){
			    		$('#plan-'+x).find('.plan-min').val('').removeClass('filled');
			    		$('#plan-'+x).find('.plan-max').val(y).addClass('filled');
			    	}else{
			    		$('#plan-'+x).find('.plan-min').val(y).addClass('filled');
			    		$('#plan-'+x).find('.plan-max').val('').removeClass('filled');
			    	}
			    }
			}
			
			var pak = '';
			var cmd = '';
			if(w.length>0||y.length>0){
				//if($(this).hasClass('plan-min')){
			//		if(w.length&&$.isNumeric(w)){
						pak = y+'-'+w;
						cmd =	 (y.length>0? y +'<=' +x +(w.length>0?' and ':''):'')
							+(w.length>0? x +'<=' +w :'')+(y.length>0&&x=="et"?' and et!=126':'');
			//		}else{
			//			pak = y + '+';
			//			cmd = v + '<=' + x;
			//		}
			//	}else{
			//		if(y.length&&$.isNumeric(y)){
			//			pak = y + '-' + v;
			//			cmd = ''+y+'<='+x+' and '+x+'<='+ v;
			//		}else{
			//			pak = v+'-';
			//			cmd = ''+v+'<='+x+'';
			//		}
			//	}
				$(this).siblings('.truval').text(cmd);
			}
		});//change #APPprix etc ranges
		$('.textbox').on('change','#APPMOT',function(){
			var m = $(this).val();
			$('#plan-MOT input').val(m);
			$(this).siblings('.truval').text('( MOT="'+m+'" )');
		});//change #APPMOT
		/*$('body').on("click","input:radio",function (e) {
		var inp=$(this); //cache the selector
		if (inp.is(".theone")) { //see if it has the selected class
			inp.prop("checked",false).removeClass("theone");
			return;
		}
		$("input:radio[name='"+inp.prop("name")+"'].theone").removeClass("theone");
		inp.addClass("theone");
	});*///Enable toggleable radio inputs
		$('#dynputdiv').on('change','.quadbar-spacerinp',function(){
			if($(this).val()==''){
				$(this).removeClass('filled');
			}/*else{
				$(this).addClass('filled');
			}*/
		});
		/*$('#APP-inpcase').on('click','#reframe-trybar',function(){
			$('#llastplace').remove();
			$.get('searchbar-ajax.php?t='+CharChoice+'&lg='+window.PAYS, function(data) {
				$('<div id="llastplace">'+data+'</div>').insertBefore('#tester');
				});
		});*///reload the form for debugging
		/*$('.textbox').on('click','.spacer_textarea .okay',function(){
			
		});*/
		/*$('body').on('mouseover','.tooltip_toggle',function(event){
			var text = $(this).attr('tooltip_data');
			var p=$(this).position();
			var w=p.top-$(this).height();
			$('.tooltip').text(text);
			$('.tooltip').css({
				'left':p.left,
				'top': w
			});
			$('.tooltip').removeClass('nodisplay');
		}).mouseout(function(){
			$('.tooltip').addClass('nodisplay');
		});*/
		/*$('.textbox').on('mouseenter','.spacer_expand',function(){
			APP.s=$(this).children('.spacerinp').attr('size');
			if($(this).children
			$(this).children('.spacerinp').attr('size',$(this).children('.spacerinp').val().length);
			$(this).children('.spacerinp').css({
				'width':'auto'
			});
			$(this).css({'position':'fixed','z-index':'99999999'});
		}).on('mouseleave','.spacer_expand',function(){
			var fontspecs= {
				fontsize:$('.spacerinp').css('font-size'),
				fontfamily:$('.spacerinp').css('font-family'),
				fontweight:$('.spacerinp').css('font-weight')
			};
			$(this).children('.spacerinp').attr('size',APP.s);
			$(this).children('.spacerinp').css({
			'width':APP.workers.measureText($(this).children('.spacerinp').val(),fontspecs)
			});
			$(this).css({'position':'relative','z-index':'initial'});
		});*/
		$('#APP-gotopg').keyup(function(e){
			var t = $(this).val();
			if(t>APP.pagecount||!$.isNumeric(t)||t==""){
				$(this).addClass('invalid-page');
				$('.gotopg').prop('disabled',true);
			}else{
				$(this).removeClass('invalid-page');
				$('.gotopg').prop('disabled',false);
			}
			if(e.which==13){
				$('.gotopg').click();
			}
		});
		$('#APP-gotopg').focusout(function(){
			if($(this).val()==""||$(this).hasClass('invalid-page')){
				$(this).val(APP.currentpage);
				$(this).removeClass('invalid-page');
			}
		});
		$('.gotopg').click(function(){
			var t = $('#APP-gotopg').val();
			if($(this).prop('disabled')==false){
				if($('#pagina'+t).length){
					$(window).scrollTop($('#pagina'+t).offset().top);
					APP.workers.handlebar();
				}else{
					APP.currentpage=Number(t);
					APP.workers.adCall('gotopg',APP.openurl,t);
				}
			}
		});
		$('#euroavg').click(function(){
			APP.workers.adCall('euroavg',APP.openurl,1);
		});
		//---------------------------------------------------------------------------------------------------------------
		//AUTOCOMPLETE SUGGEST MENU EVENT LISTENERS----------------------------------------------------------------------
		$(".APP-menu").click(function(event) {
        	event.stopPropagation();
			if(p == "") {
				$(".APP-menu").addClass("hidden");
			}
        });
        APP.pageselect = function(e,src) {
			var $listItems = src;
			var key = e.keyCode,
				$selected = $listItems.filter('.taken'),
				$current;

			if ( key != 40 && key != 38 ) return;

			$listItems.removeClass('taken');

			if ( key == 40 ) // Down key
			{
				var appmenuheight = $('.APP-menu').height();
				var selectnext = $selected.next();
				if ( ! $selected.length || $selected.is(':last-child') ) {
					$current = $listItems.eq(0);
					$('.APP-locbox').scrollTop(0);
				}
				else {
					if(selectnext.position().top > appmenuheight) {
						$('.APP-locbox').scrollTop($('.APP-locbox').scrollTop() + $selected.next().height());
					}
					$current = $selected.next();
				}
			}
			else if ( key == 38 ) // Up key
			{
				if ( ! $selected.length || $selected.is(':first-child') ) {
					$current = $listItems.last();
					$('.APP-locbox').scrollTop($('.APP-locbox')[0].scrollHeight);
				}
				else {
					$current = $selected.prev();
					if($selected.prev().position().top < $('.APP-locbox').scrollTop()) {
						$('.APP-locbox').scrollTop($('.APP-locbox').scrollTop() - $selected.prev().height());
					}
				}
			}

			$current.addClass('taken');
			if(src.parents('.APP-locbox').length){APP.workers.ghostSuggest($current);}
		}//Function for keyboard scrolling in the autocomplete menu
		//---------------------------------------------------------------------------------------------------------------
        //STOP PROPAGATION EVENT LISTENERS---------------------------------------------------------------------------
        $(".APP-menu li input, .APP-menu select").click(function(event) {
        	event.stopPropagation();
        });
        $('html').on('click',function(e) {
			$(".APP-menu").addClass("hidden");
		});
		$('#dynputdiv').on('click','.spacerinp', function(event) {
			event.stopPropagation();
		});
		$('#dynputdiv').on('dblclick','.spacerinp', function(event) {
			event.stopPropagation();
			if ($(this).setSelectionRange) {
				$(this).setSelectionRange(0, $(this).val().length);
			}else {
				$(this).select();
			}
		});
		/*$('#bookmarkthissearch, #searchhistorymenu').click(function(){
			setTimeout(function() {
			if($('.floatingmenuitem').hasClass('nodisplay')){
				$('#APP-inpcase').mouseenter(function() {
					$('#APP-menubaroptions, #APP-pgnumber').removeClass('hidden');
				}).mouseleave(function() {
					$('#APP-menubaroptions:not(#hide-menubaroptions), #APP-pgnumber').addClass('hidden');
				});
			}else {
				$('#APP-inpcase').off('mouseenter, mouseleave');
			}
			},50);
		});*/
		//---------------------------------------------------------------------------------------------------------------
		//SUPPORT TICKET MENU EVENT LISTENERS----------------------------------------------------------------------------
		//$("#ticketmaintext").jqte({source: false, unlink: false, link: false});
		//JSON request function for support ticket menu
        APP.ticketJSON1 = function() {
        	$('#APP-inboxbox').remove();
        	$('body').append('<div id="APP-inboxbox" class="nodisplay">'+
        		'<div id="APP-inbox">'+
        			'<div id="APP-inbox-left">'+
        				'<ul style="padding-left:0;">'+
        					'<li class="APP-inbox-selected">'+lng('Criar um novo ticket','Pt')+lng('Créer un nouveau ticket','Fr')+lng('Create new ticket','En')+'</li>'+
        					'<li id="APP-Opentrigger">'+lng('Tickets em aberto','Pt')+lng('Tickets ouverts','Fr')+lng('Open tickets','En')+'</li>'+
        					'<li id="APP-closetrigger">'+lng('Tickets fechados','Pt')+lng('Tickets fermés','Fr')+lng('Closed tickets','En')+'</li>'+
        					'<li id="selectimcontact-trigger">'+lng('Contato Selectim','Pt')+lng('Contact Selectim','Fr')+lng('Contact Selectim','En')+'</li>'+
        				'</ul>'+
        			'</div>'+
        			'<div id="APP-inbox-right" style="display:inline-block;overflow-y:auto;max-height:400px;max-width:600px;">'+
        				'<div id="APP-inbox-innercontent" class="inbox-contenttype nodisplay">'+
        					'<div style="text-align:center;border:1px solid black;background-color:#D94A38;color:#FFFFFF;">'+lng('Tickets em aberto','Pt')+lng('Tickets ouverts','Fr')+lng('Open tickets','En')+'</div>'+
        						'<ul style="padding-left:0;"></ul>'+
        					'</div>'+
        					'<div id="APP-closedinbox" class="nodisplay inbox-contenttype">'+
        					'<div style="text-align:center;border:1px solid black;background-color:#D94A38;color:#FFFFFF;">'+lng('Tickets fechados','Pt')+lng('Tickets fermés','Fr')+lng('Closed tickets','En')+'</div>'+
        				'</div>'+
        				'<div id="newticketcontent" class="inbox-contenttype">'+
        				'<div style="text-align:center;border:1px solid black;background-color:#D94A38;color:#FFFFFF;margin-top:10px;margin-bottom:10px;">'+lng('Criar um novo ticket','Pt')+lng('Créer un nouveau ticket','Fr')+lng('Create new ticket','En')+'</div>'+
        				'<span>'+
        				'<select>'+
        					'<option value="0">'+lng('Pedir ajuda','Pt')+lng('Demander de l\'aide','Fr')+lng('Ask for help','En')+'</option>'+
        					'<option value="1">'+lng('Sugerir uma melhoria','Pt')+lng('Proposer une amélioration','Fr')+lng('Suggest an improvement','En')+'</option>'+
        					'<option value="2">'+lng('Pedir uma corre&#231;&#227;o','Pt')+lng('Demander une correction','Fr')+lng('Request a correction','En')+'</option>'+
        				'</select>'+
        				'</span><br>'+
        				'<div style="margin-top: 5px;">'+lng('Assunto','Pt')+lng('Sujet','Fr')+lng('Subject','En')+':<br>'+
        					'<input id="assunto" type="text" style="width: 90%;" maxlength="96" autocomplete="off"><br>'+
        				'</div>'+
        				'<div id="Describepro" style="margin:3px;margin-top:5px;">'+lng('Descrição','Pt')+lng('Description','Fr')+lng('Description','En')+':</div>'+
        				'<textarea style="width:100%;margin-right:3px;" rows="4" id="ticketmaintext"></textarea><br><br>'+
        				'<input id="notifytrigger" data-toggle="#ticketcontact" type="checkbox">'+lng('Por favor responda','Pt')+lng('répond s\'il te plait','Fr')+lng('Please respond','En')+'<br>'+
						'<div id="ticketcontact" class="nodisplay"><br>'+
							'<input id="tickettel" type="text" placeholder="'+lng('Telefone (opcional)','Pt')+lng('téléphone (facultatif)','Fr')+lng('Telephone (optional)','En')+'">'+
							'<input id="ticketemail" placeholder="Email" type="text">'+
						'</div><br>'+
        				'<div id="ticketwarning" class="nodisplay" style="border-radius: 3px; border: 1px solid #898989; background-color: #e2bd93;">'+
        				' Por favor, preencha todos os campos. '+
        				'</div>'+
        				'<button class="suggestmenusubmit" disabled>OK</button>'+
        			'</div>'+
        			'<div id="selectimcontact" class="nodisplay inbox-contenttype" style="border-radius:3px;border:1px solid #000;text-align:center;width:500px;">'+
        		'<strong>Selectim, Jean-Francois Rocheman</strong><br>39-73 48th Street<br>'+
        		'Sunnyside, NY 11104<br>'+lng('estados Unidos','Pt')+lng('États Unis','Fr')+lng('United States','En')+'<br><strong>E-Mail</strong> : jrocheman@gmail.com<br>'+
        		'<strong>'+lng('Telefone(estados Unidos)','Pt')+lng('téléphone ( États-Unis )','Fr')+lng('Telephone (United States)','En')+'</strong> : +33 972 424 600 </div>'+
        			'</div>'+
        		'<div id="APP-inbox-textareadiv" style="text-align:center;" class="nodisplay inbox-contenttype">'+
        			'<textarea id="APP-inbox-respondarea"></textarea>'+
        		'<div>'+
        			'<button id="APP-inbox-Reply">'+lng('Mandar','Pt')+lng('Envoyer','Fr')+lng('Send','En')+'</button><button id="APP-inbox-Closetix">'+lng('Fechar ticket','Pt')+lng('Fermer ticket','Fr')+lng('Close Ticket','En')+'</button>'+
        		'</div>'+
        	'</div>'+
        	'</div></div></div>');
        	$('#APP-inbox-respondarea').jqte({source: false, unlink: false, link: false,color:false});
        	$('#ticketmaintext').jqte({source: false, unlink: false, link: false,color:false});
        	if(window.TELP) {
			$("#tickettel").val(window.TELP);
			}
			if(window.SSP1) {
				$("#ticketemail").val(window.SSP1);
			}
        	var viewcount = 0;
        	$.getJSON("autocompleteportu2.php?support=1&supportlist=1", function( response ) {
				var data = response[0];
				var alertdata = response[1];
				//data.sort(function(a,b){return a.ticket - b.ticket});
				//data.reverse();
				if(data.length > 0) {
					if(data.length > ($('.tickreplytrigger').length + $('.tickettabletrigger').length)){
						$("#APP-inbox-innercontent ul li").remove();
						for(x=0;x<data.length;x++) {
							if(data[x].ticket == data[x].msgid) {
								//var vb = new RegExp(/``/g);
								//var vv = data[x].msg.replace(vb,';');
								//var vc = vv.replace(/~/g,'"');
								data[x].msg = data[x].msg.replace(/\x60\x60/g,"\x3B");
								data[x].msg = data[x].msg.replace(/~/g,"\x22");
								var getsubject = function(p) {
									var p1 = p;
									if(p.length > 35) {
										p1 = p.substring(0,35) + "...";
									}
									return p1;
								}
								var name = '';
								if(typeof(data[x].sp2) !== 'undefined' && typeof(data[x].sp2p) !== 'undefined') {
									name = data[x].sp2p + ' ' + data[x].sp2;
								}
								$('#APP-inbox-innercontent ul').append('<li style="list-style:none;"class="tickettabletrigger" data-msgid="'+ data[x].msgid +'" data-ticksid="' + data[x].id +'">' + APP.circlecheck(data[x].urg) + '  #<span class="ticknumtick">' + data[x].ticket + '</span> "' + getsubject(data[x].sub) + '" <span>' + APP.adminuser(data[x]) + ' <span style="float:right;">' + data[x].fst + '</span> </li>');
								$('#APP-inbox-innercontent ul').append('<li class="nodisplay" data-ticksid="' + data[x].id +'" id="ticktable' + data[x].ticket + '"><div class="APP-ticketbody"><div class="APP-inbox-cat"><strong>'+lng('Assunto','Pt')+lng('Sujet','Fr')+lng('Subject','En')+':</strong> ' + data[x].sub + '</div><div class="APP-inbox-cat"><strong>'+lng('A partir da','Pt')+lng('De','Fr')+lng('From','En')+':</strong> ' + name + (typeof(data[x].mel)!=="undefined"?(' (' + data[x].mel + ')'):"") + '</div><div class="APP-inbox-cat"><strong>'+lng('Mensagem','Pt')+lng('Message','Fr')+lng('Message','En')+':</strong><br> ' + (typeof(data[x].msg)!=="undefined"&&typeof(data[x].msg)!=="null"?data[x].msg:"") + '</div><div>' + data[x].tel + '</div></div></li>');
								if(APP.user == "T4P") {
									$("#APP-inbox-innercontent li:last-child").append('<div class="adminmenutrigger">Admin menu: show</div><div class="nodisplay"><table><tr><td style="background-color:#6dd699;"><strong>Tech. Menu</strong> <br> Reference number: <span class="tickrefnumber">' + data[x].ticket + '</span><br>User: <span class="tickuserid">' + data[x].sp2p + ' ' + data[x].sp2 + '</span><br>Search assoc. with ticket:<br> <div style="max-width: 300px;overflow-x:scroll;">' + data[x].url + '</div><br>User IP: ' + data[x].ip + '<br>User agent: ' + data[x].ua + '</td></tr></table></div>');
								}
							}
						}
						for(x=0;x<data.length;x++) {
							var name = '';
								if(typeof(data[x].sp2) !== 'undefined' && typeof(data[x].sp2p) !== 'undefined') {
									name = data[x].sp2p + ' ' + data[x].sp2;
								}
							if(data[x].ticket != data[x].msgid) {
								/*var placetoput = false;
								if(data[x].viewed == '0000-00-00 00:00:00' && data[x].id !== window.SID) {
									viewcount += 1;
									placetoput = true;
								}*/
								//var fn = new RegExp(/``/g);
								//var gg = data[x].msg.replace(fn,';');
								data[x].msg = data[x].msg.replace(/\x60\x60/g,"\x3B");
								data[x].msg = data[x].msg.replace(/~/g,"\x22");
								var gg = data[x].msg;
								var parentSID = $("#ticktable" + data[x].ticket).attr('data-ticksid');
								if(typeof(gg) != "undefined" && gg != "" && gg != "undefined") {
									$("#ticktable" + data[x].ticket).append('<li class="tickreplytrigger"><span class="parentSID nodisplay">' + parentSID + '</span><span class="nodisplay ticknumtick">' + data[x].ticket + '</span><span class="nodisplay tickSID">' + data[x].id + '</span><span class="nodisplay msgid">' + data[x].msgid + '</span><span class="nodisplay tickviewed">' + data[x].viewed + '</span>'+lng('Responder de','Pt')+lng('Réponse de','Fr')+lng('Reply From','En')+': '+ data[x].sp1 +'<span style="position:relative;float:right">' + data[x].fst + '</span></li><li class="tickreply"><div class="APP-inbox-cat"><strong>'+lng('Mensagem','Pt')+lng('Message','Fr')+lng('Message','En')+':</strong> ' + data[x].msg + '</div></li>');
								}
								if(data[x].cls != '0000-00-00 00:00:00') {//&& placetoput == false
									var parenttrigger = $("#ticktable" + data[x].ticket).prev();
									var mm = parenttrigger.detach();
									var parenttable = $("#ticktable" + data[x].ticket).detach();
									$('#APP-closedinbox').append(mm);
									$('#APP-closedinbox').append(parenttable);
									//$('#APP-inbox-innercontent ul').append('<li class="closeticketlink" data-tickettarget="' + data[x].ticket + '">Ticket #' + data[x].ticket + ' Closed by ' + name + '</li>');
									/*$('.closeticketlink').click(function() {
										$('#APP-inbox-right li').addClass('nodisplay');
										$('#APP-closedinbox').removeClass('nodisplay');
										$('#ticktable' + $(this).attr('data-tickettarget')).removeClass('nodisplay');
									});*/
								}
							}
						}
						/*var checkalertemail = function( input ) {
							var email = '<span class="oi envelope redhover addbookmarkemail" data-glyph="envelope-closed" title="'+lng('Adicionar um alerta de e-mail para este bookmark','Pt')+lng('Add an email alert to this bookmark','En')+lng('Ajouter une alerte e-mail à ce bookmark','Fr')+'" aria-hidden="true"></span>';
							if( input == '1') {
								email = '<span class="oi envelope redhover removebookmarkemail" data-glyph="envelope-open" style="color:yellow;" title="'+lng('Retirar alerta e-mail de este bookmark','Pt')+lng('Remove email alert from this bookmark','En')+lng('Retirer une alerte de ce bookmark','Fr')+'" aria-hidden="true"></span>';
								//email = '<img src="/body_a/open-iconic/envelope-closed.svg" alt="envelope-closed"height="20" width="30">';
							}
							return email;
						}*/
					}
				}
				/*if(typeof(alertdata)!=="undefined"&&alertdata.length > 0) {
					$('#afterviewbookmarks li').remove();
					for(i=0;i<alertdata.length;i++) {
						$('#afterviewbookmarks ul').append('<li class="standardli" title="' + alertdata[i].recnote.replace(/[ ]+AND[ ]+/, ', ') + '"><span style="position:relative;float:right;"><span style="margin-right:3px;"class="oi redhover removebookmark" data-glyph="circle-x" aria-hidden="true" title="'+lng('Excluir bookmark','Pt')+lng('Delete bookmark','En')+lng('Effacer bookmark','Fr')+'"></span><span>' + checkalertemail(alertdata[i].alerte) + '</span></span><span class="recnote">' + alertdata[i].rec + '</span><span class="alertlistcmd nodisplay">' + alertdata[i].sel + '</span><span class="alertlistPAK nodisplay">' + alertdata[i].recnote + '</span></li>');
					}
				}*/
			}).done(function() {
				$('#APP-closetrigger').text($('#APP-closedinbox').children('.tickettabletrigger').length+' '+lng('Tickets fechados','Pt')+lng('Tickets fermés','Fr')+lng('Closed tickets','En'));
				$('#APP-Opentrigger').text($('#APP-inbox-innercontent ul').children('.tickettabletrigger').length+' '+lng('Tickets em aberto','Pt')+lng('Tickets ouverts','Fr')+lng('Open tickets','En'));
			});
        }
        $('body').on('click','#APP-inbox-Closetix',function() {
        	var tosend = $(this).parent().siblings('.jqte').children('.jqte_editor').html();
        	var encodetosent = encodeURIComponent(tosend);
        	$.ajax({
        		url: 'autocompleteportu2.php?support=1&close=1&respond=1&tref='+ $(this).attr('data-ticknum') +'&description=' + encodetosent,
        		data: {message: encodetosent},
        		type: 'GET',
        		success: function( data ) {
        			APP.ticketJSON1();
        			$('.scotch-content').append($('#APP-inboxbox'));
        			$('#APP-inboxbox').removeClass('nodisplay');
        		}
        	});
        });//Send Close ticket msg.
        $('body').on('click','#APP-inbox-Reply',function() {
        	var tosend = $(this).parent().siblings('.jqte').children('.jqte_editor').html();
        	var encodetosent = encodeURIComponent(tosend);
        	$.ajax({
        		url: 'autocompleteportu2.php?support=1&respond=1&tref='+ $(this).attr('data-ticknum') +'&description=' + encodetosent,
        		data: {message: encodetosent},
        		type: 'GET',
        		success: function( data ) {
        			APP.ticketJSON1();
        			$('.scotch-content').append($('#APP-inboxbox'));
        			$('#APP-inboxbox').removeClass('nodisplay');
        		}
        	});
        });//Send ticket reply
        $('body').on('click',".adminmenutrigger",function() {
        	$(this).next().toggleClass("nodisplay");
        });//Toggle support ticket respond menu display
        $("#veroresult").on('click',".tickclosetrigger", function() {
        	var tosend = $(this).parent().siblings('.jqte').children('.jqte_editor').html();
        	var encodetosent = encodeURIComponent(tosend);
        	var prevtrig = $(this).parents('table').prev();
        	var thistable = $(this).parent('table');
        	$.ajax({
        		url: 'autocompleteportu2.php?support=1&close=1&respond=1&tref='+ prevtrig.children('.ticknumtick').text() +'&description=' + encodetosent,
        		data: {message: encodetosent},
        		type: 'GET',
        		success: function( data ) {
        			APP.ticketJSON1();
        			$('#supportmenu').addClass('nodisplay');
        		}
        	});
        });//HTTP POST for closing ticket in support ticket menu
        $('body').on('click', '.tickettabletrigger', function() {
        	//$('.tickettabletrigger').not($(this)).toggleClass('APP-minimized');
        	$(this).next().toggleClass("nodisplay");
        	/*if($(this).next().children('.tickreply').length > 1) {
        		$(this).next().children('.APP-ticketbody').addClass('nodisplay');
        		$(this).next().children('.tickreply').addClass('nodisplay');
        		$(this).next().children('.tickreply').last().removeClass('nodisplay');
        	}*/
        	$('.tickettabletrigger').addClass('nodisplay');
        	$('#APP-inbox-textareadiv').removeClass('nodisplay');
        	$('#APP-inbox-Reply, #APP-inbox-Closetix').attr('data-ticknum',$(this).children('.ticknumtick').text());
        });//Toggle support ticket display
        APP.circlecheck = function(data) {
        	var circlespan = '<div style="display:inline-block; border-radius:50%; width:10px; height:10px;"> </div>';
        	switch(data) {
        		case "0":
        			circlespan = '<div style="display:inline-block; border-radius:50%; width:10px; height:10px; background-color:#68f87e;"></div>';
        			break;
        		case "1":
        			circlespan = '<div style="display:inline-block; border-radius:50%; width:10px; height:10px; background-color:#f7f271;"></div>';
        			break;
        		case "2":
        			circlespan = '<div style="display:inline-block; border-radius:50%; width:10px; height:10px; background-color:#c44040;"></div>';
        			break;
        		default:
        			break;
        	}
        	return circlespan;
        }//Function to add color status/urgency display indicators
        APP.adminuser = function(data) {
        	var userinfo = "";
        	if(APP.user == "T4P") {
        		userinfo = data.sp2p + ' ' + data.sp2;
        	}
        	return userinfo;
        }//User access level check for support ticket
    	$('#veroresult').on('click', '.adminrespondbtn', function() {
        	var tosend = $(this).parent().siblings('.jqte').children('.jqte_editor').html();
        	var encodetosent = encodeURIComponent(tosend);
        	$.ajax({
        		url: 'autocompleteportu2.php?support=1&respond=1&tref='+ $(this).parents('table').prev().children('.ticknumtick').text() +'&description=' + encodetosent,
        		data: {message: encodetosent},
        		type: 'GET',
        		success: function( data ) {
        			$('#supportmenu').addClass('nodisplay');
        			APP.ticketJSON1();
        		}
        	});
        });//HTTP POST for responding to ticket (without closing) in support ticket menu
        $("#veroresult").on("click", ".adminticketreply",function() {
        	$(this).parent().parent().siblings('.adminticketform').children().children(".adminarea").jqte({source: false});
        	$(this).parent().parent().siblings(".adminticketform").toggleClass("nodisplay");
        });//Toggle support ticket display
        $("#veroresult").on("click",".tickreplytrigger", function() {
        	var childrentickviewed = $(this).children('.tickviewed');
        	if(childrentickviewed.text() == '0000-00-00 00:00:00' && $(this).children('.parentSID').text() == window.SID && $(this).children('.tickSID').text() !== window.SID) {
        		var msgid = $(this).children('.msgid').text();
        		var ticknum = $(this).children('.ticknumtick').text();
        		$.ajax({
        			url: 'autocompleteportu2.php?support=1&viewed=1&tref=' + ticknum + '&msgid=' + msgid,
        			success: function( data ) {
        				childrentickviewed.text(data);
        				APP.viewcount -= 1;
        				if(APP.viewcount == 0) {
        					$("#APP-viewcount").remove();
        				}else {
        					$('#APP-viewcount').text(APP.viewcount);
        				}
        			}
        		});
        	}
        	$(this).next().toggleClass('nodisplay');
        });//HTTP POST to indicate whether a support ticket post has been viewed
        $('#supportbtn').click(function() {
        	$('.floatingmenuitem:not(#reportmenu)').addClass("nodisplay");
        	$('.APP-menubaroptionsspan:not(#supportbtn,#testexpandall)').removeClass('toggled');
        		$(window).scrollTop(0);
        		APP.ticketJSON1();
        		$('.scotch-modal').remove();
				var b = new Modal({
					content: '',
					className: 'APP-ticketmodal',
					maxHeight: 400,
					minHeight: 400
				});
				b.open();
				$('.scotch-content').append($('#APP-inboxbox'));
				$('#APP-inboxbox').removeClass('nodisplay');
        	$('.scotch-overlay').scroll(function(event) {
        		event.preventDefault();
        	});
        	$('#APP-inbox').scroll(function(event) {
        		event.stopPropagation();
        	});
        	$('.scotch-modal').css('top','50%');
        });//Toggle display of main support options menu
        $(".reportmenux").click(function() {
        	if(!APP.togglemenu) {
        		APP.togglemenu = true;
        	}else {
        		APP.togglemenu = false;
        	}
        	$(".supportmenu").addClass("nodisplay");
        });//Close the support menu
        $('body').on('keyup',"#newticketcontent .jqte_editor, #assunto", function() {
        	if($("#assunto").val() == "" && $("#newticketcontent .jqte_source").html() == "") {
        		$(".suggestmenusubmit").prop("disabled",true);
        	}else {
        		$(".suggestmenusubmit").prop("disabled",false);
        	}
        });//validation check on textarea keyup for submitting new support ticket
        $('body').on('click',".suggestmenusubmit",function() {
        	var ischecked = $('#reportmenu input[type="checkbox"]');
        	var datacmds = "";
        	$('.truval').each(function() {
        		datacmds += $(this).text() + ' ';
        	});
        	var tosend = $(this).siblings('.jqte').children('.jqte_editor').html();
        	var encodetosent = encodeURIComponent(tosend);
        	var datam = {
        		"description": encodetosent,
        		"urgency": $("#reportmenu select").val(),
        		"openURL": APP.openurl.replace("&","%26"),
        		"openCMDS": datacmds,
        		"tel": $("#tickettel").val(),
        		"email": $("#ticketemail").val(),
        		"subject": $("#assunto").val()
        	};
        	var dorl = 'autocompleteportu2.php?support=1&short=' + encodeURIComponent($("#assunto").val().substring(0,300));
        	dorl += '&description=' + encodetosent;
        	dorl += '&urgency=' + $("#reportmenu select").val();
        	dorl += '&openURL=' + encodeURIComponent(APP.openurl.replace("&","%26"));
        	dorl += '&openCMDS=' + encodeURIComponent(datacmds);
        	if($('#notifytrigger').prop('checked')) {
        		dorl += '&tel=' + $("#tickettel").val();
        		dorl += '&email=' + encodeURIComponent($("#ticketemail").val());
        	}
        	dorl += '&subject=' + encodeURIComponent($("#assunto").val());
        		$.post(dorl,{"ticket":JSON.stringify(datam)}).done(function( data ) {
        			$("#notifia").removeClass("nodisplay");
        			if($('#notifytrigger').prop('checked')) {
        				$("#obligado").html("Obrigado.<br> Entraremos em contato o mais breve possivel.");
        			}else {
        				$("#obligado").text("Obrigado.");
        			}
        			$("#ticketcontent").addClass("nodisplay");
        			$("#assunto").val("");
        			$('#newticketcontent .jqte').children('.jqte_editor').html("");
        				APP.ticketJSON1();
        				$('.scotch-content').append($('#APP-inboxbox'));
        				$('#APP-inboxbox').removeClass('nodisplay');
        		})
        		.fail(function (jqXHR, textStatus, error) {
    				$("#supportproblema").removeClass("nodisplay");
    			});
        });//HTTP POST for submitting new support ticket request
        //Toggle respond query display support menu
        $("#notifyreturn").click(function() {
        	$("#notifia").addClass("nodisplay");
        	$("#ticketcontent").removeClass("nodisplay");
        });//Return to main menu after successfully submitting ticket
        $("#supportdebugtrigger").click(function() {
        	$("#supportdebug").toggleClass("nodisplay");
        });//Toggle display of debug info for support ticket
        $("#veroseu").click(function() {
        	$("#veroresult").toggleClass("nodisplay");
        	$(this).toggleClass('toggled');
        	if($(this).hasClass('toggled')) {
        		$(this).css('background-color','blue');
        		APP.ticketJSON1();
        	}else {
        		$(this).css('background-color','#7BABE2');
        	}
        });//Support history menu toggle display
        $('body').on('click', '#APP-inbox-left li', function() {
        	$('#APP-inbox-left li').removeClass('APP-inbox-selected');
        	$(this).addClass('APP-inbox-selected');
        	$('.inbox-contenttype').addClass('nodisplay');
        });
        $('body').on('mouseover','.telwin, #historymenu, #afterviewbookmarks',function(){
        	APP.wpos=$(window).scrollTop();
        	//$('html').css({'overflow':'hidden','padding-right':'17px'});
        	/*var t = $(window).scrollTop();
        	$('html').css({'position':'fixed','overflow':'scroll'});
        	$(window).scrollTop(t);*/
        	$(window).scroll(APP.workers.prevscroll);
        	
        }).on('mouseout',function(){
        	$(window).off('scroll',APP.workers.prevscroll);
        });
        $('body').on('click','.telwin',function(){
        	$('.telwin').css('z-index','3');
        	$(this).css('z-index','4');
        });
        $('body').on('click','#selectimcontact-trigger', function() {
        	$('#selectimcontact').removeClass('nodisplay');
        });//Show selectim contact information
        $('body').on('click','#APP-inbox-left li:first-of-type',function() {
        	$('#newticketcontent').removeClass('nodisplay');
        	//$('#APP-inbox-left').addClass('nodisplay');
        	/*$('#APP-inbox-left').css({
        		'display':'none'
        	});*/
        });//Toggle display of new ticket menu
        $('body').on('click','.scotch-close',function(event) {
        	if($('#APP-inbox-left').hasClass('nodisplay')) {
        		event.stopPropagation();
        		$('#newticketcontent').addClass('nodisplay');
        		$('#APP-inbox-left').removeClass('nodisplay').css({
        			'display':'inline-block'
        		});
        		$('#APP-inbox-innercontent').removeClass('nodisplay');
        		$('.APP-inbox-selected').removeClass('APP-inbox-selected');
        		$('#APP-inbox-left li:first-child').addClass('APP-inbox-selected');
        	}
        });//Close ticket menu
        $('body').on('click','#APP-closetrigger',function() {
        	$('#APP-inbox-right').children().addClass('nodisplay');
        	$('#APP-closedinbox').removeClass('nodisplay');
        	$('#APP-closedinbox li').addClass('nodisplay');
        	$('.tickettabletrigger, .tickreply, .tickreplytrigger').removeClass('nodisplay');
        });//Show closed tickets
        $('body').on('click','#APP-inbox-left li:nth-child(2)',function() {
        	$('#APP-inbox-right').children().addClass('nodisplay');
        	$('#APP-inbox-innercontent').removeClass('nodisplay');
        	$('#APP-inbox-innercontent li').addClass('nodisplay');
        	$('.tickettabletrigger, .tickreply, .tickreplytrigger').removeClass('nodisplay');
        });//Ticket menu option buttons styling
        $("#newticketbtn").click(function() {
        	$("#newticketcontent").toggleClass("nodisplay");
        	//$("#newticketcontent, APP-inbox-textareadiv").removeClass("nodisplay");
        	$('APP-inbox-innercontent, #selectimcontact').addClass('nodisplay');
        	$(this).toggleClass('toggled');
        	if($(this).hasClass('toggled')) {
        		$(this).css('background-color','blue');
        	}else {
        		$(this).css('background-color','#7BABE2');
        	}
        });//New ticket toggle display
        $("#contacto").click(function() {
        	$("#selectimcontact").toggleClass("nodisplay");
        	$(this).toggleClass('toggled');
        	if($(this).hasClass('toggled')) {
        		$(this).css('background-color','blue');
        	}else {
        		$(this).css('background-color','#7BABE2');
        	}
        });//Contact info toggle display
        $('#triggercloseticket').click(function() {
        	$('#ticketcloseddisplay').toggleClass('nodisplay');
        	$('#veroresult').scrollTop($(this).offset().top);
        });//Toggle display of closed support tickets 
        $(window).mousemove(function(e){
        	window.lastX = e.screenX;
			window.lastY = e.screenY;
		});
		//---------------------------------------------------------------------------------------------------------------
		//SEARCH HISTORY EVENT LISTENERS---------------------------------------------------------------------------------
		$('#historymenu').click(function(event){
			event.stopPropagation();
		});
		$('#historytgl').click(function() {
			$('.historymenu').toggleClass('nodisplay');
		});//Toggle display of search history menu
		$('#historymenu').on('click','.historymenu li:first-of-type',function() {
			$('.APP-menubaroptionsspan').removeClass('toggled');
			$(this).siblings().toggleClass('nodisplay');
			$(this).toggleClass('caretflip');
			if($(this).hasClass('caretflip')) {
				$(this).children('.carettoggle').html('&#9650;');
			}else {
				$(this).children('.carettoggle').html('&#9660;');
			}
		});
		$('#historymenu').on('click','.historymenu li:not(:first-of-type)',function(){
			$('.APP-menubaroptionsspan').removeClass('toggled');
			$('#placeholdertext').addClass('nodisplay');
			APP.workers.clickHistory($(this),1);
		});//Add a search to the searchbar from your history
		$('.dbghistorymenu').on('click','li:not(:first-of-type)',function(){
			console.log('clicked');
			APP.workers.clickHistory($(this),'top');
		});
		$('#searchhistorymenu').click(function(event) {
			if(!$('.historymenu li')) {
				APP.workers.initializeHistory();
			}
			$('#historymenu').css({
				"left": $("#searchhistorymenu").position().left,
				"top": $("#searchhistorymenu").position().top + $("#searchhistorymenu").height()
			});
		});//Toggle display of history menu
		$('#historyitem_collapse').click(function() {
			$('.APP-menubaroptionsspan').removeClass('toggled');
			$(this).parent().siblings().children('.historymenu li:not(:first-of-type)').toggleClass('nodisplay');
			$(this).toggleClass('caretflip');
			$('.historymenu li:first-of-type').toggleClass('caretflip');
			if($(this).hasClass('caretflip')) {
				$('.caretflip').children('.carettoggle').html('&#9650;');
			}else {
				$('.carettoggle').html('&#9660;');
			}
		});
		//---------------------------------------------------------------------------------------------------------------
		//BOOKMARKS MENU EVENT LISTENERS---------------------------------------------------------------------------------
		$('#newbookmarksmenu').on('click','#bookmicroscope',function(){
			if($(this).attr('data-glyph')=="zoom-out"){
				$(this).attr('data-glyph','zoom-in');
			}else{
				$(this).attr('data-glyph','zoom-out');
			}
			$('.bookmark-desc').toggleClass('nodisplay');
		});
		$('#afterviewbookmarks').on('click','li',function() {
			var that = $(this);
			$('#placeholdertext').addClass('nodisplay');
			APP.workers.clearPlan();
			var test = $(this).children('.alertlistPAK').html().match(/[!]Err[^!]*[!]/)
				if(test){
					alert('Err!: '+ test[0]);
					return;
				}
				var b = $(this).children('.alertlistPAK').html().split(/[ ]+AND[ ]+?/);
				var c = $(this).children('.alertlistcmd').text().replace(/([<>]=)([A-Za-z]+)[ ]+?(AND)[ ]+?\2\1/g,"$1$2 and $2$1");
				c=c.replace(/\bAND +AND\b/g,'AND');
				$(this).children('.alertlistcmd').text(c);
				c = c.split(/[ ]+AND[ ]+?/);
				for(i=0;i<c.length;i++) {
					if(c[i] == "21J&lt;=date") {
						c.splice(i,1);
					}
				}
				for(i=0;i<b.length;i++) {
					var typearray=b[i].split(';');
					var cat=[typearray[2],typearray[3],typearray[4],typearray[5]];
					APP.workers.insertSpacer(typearray[typearray.length-1],c[i],(typearray[0]+': '),typearray[1],cat);
				}
				setTimeout("APP.workers.respace();",10);
				$('.APP-menubaroptionsspan').removeClass('toggled');
				$('#newbookmarksmenu').scrollTop(0);
				$('#newbookmarksmenu').addClass('nodisplay');
				$('#APP-recnote').text($(this).children('.recnote').html());
			/*catch(err) {
				console.log(err);
				alert(err+'\n\nPAK:'+that.children('.alertlistPAK').html()+'\nCMD: '+ that.children('.alertlistcmd').html());
				try{APP.workers.respace();}catch(err){console.log(err);}
			}*/
		});//(on click li) Add a search from your bookmarks
		$('#dynputdiv').on('click','#bookmarkthissearch',function(event) {
			/*if(!$('#afterviewbookmarks li').length) {
				APP.ticketJSON1();
			}*/
			//event.stopPropagation();
			//$('.APP-menu').addClass('hidden');
			//$(this).toggleClass('toggled');
			$("#newbookmarksmenu").css({
				"left": $("#bookmarkthissearch").position().left,
				"top": $('#bookmarkthissearch').position().top + $('#bookmarkthissearch').height() + 5
			});
			/*function yada(event) {
				$('.floatingmenuitem').addClass('nodisplay');
				$('.toggled').removeClass('toggled');
				$('body').off('click',yada);
			}
			$('body').click(yada);
			$("#newbookmarksmenu").toggleClass("nodisplay");
			$('.floatingmenuitem:not(#newbookmarksmenu)').addClass('nodisplay');
			$('.APP-menubaroptionsspan:not(#bookmarkthissearch,#testexpandall)').removeClass('toggled');*/
		});//(#bookmarkthissearch)Toggle display of bookmarks menu
		$('#newbookmarksmenu').on('click','#cancelbookmarksbtn',function() {
			$('#newbookmarksmenu').addClass('nodisplay');
			$('.APP-menubaroptionsspan').removeClass('toggled');
			$('#bookmarknameinput').val('');
			$('#emailalerttoggle').prop('checked',false);
		});//(#cancelbookmarksbtn) Cancel creation of new bookmark
		$('#newbookmarksmenu').on('click','#confirmnewbookmarkbtn',function() {
			if(!$('.spacer').length) {
				var na = lng('Your searchbar is currently empty. Please add some terms','En')+lng('Votre recherche est actuellement vide . S\'il vous plaît ajouter quelques termes','Fr')+lng('Seu searchbar está vazio. Por favor, adicione algumas palavras','Pt');
				alert(na);
				return;
			}else{
				var statusval = 0;
				if($('#emailalerttoggle').prop('checked')) {
					statusval = 1;
				}
				if($('#bookmarknameinput').val()=="") {
					alert(lng('Please enter a name for your alert','En')+lng('Entrer un nom pour votre alerte','Fr')+lng('Insira um nome para o seu alerta','Pt'));
					return false;
				}else{
					if($(this).data('valid')=='0'){
						var r = confirm('noresult');
						if(r==true){
							setBkmrk(statusval);
						}else{
							return false;
						}
					}else{
						setBkmrk(statusval);
					}
				}
			}
		});//(#confirmnewbookmarkbtn) Create a new bookmark button
		$('#newbookmarksmenu').on('click','.addbookmarkemail, .removebookmarkemail',function(event) {
			event.stopPropagation();
			event.preventDefault();
			var parenttext = $(this).parents('.standardli').children('.recnote').text();
			var alertstatus = 0;
			var that = $(this);
			var parentname = $(this).parent();
			if($(this).hasClass('addbookmarkemail')) {
				alertstatus = 1;
			}
			$.ajax({
				method: 'GET',
				url: 'autocompleteportu2.php?bookmark=1&al=' + alertstatus + '&name=' + parenttext
			}).done(function(response) {
				if(response == "1"||response == 1) {
					that.remove();
					if(alertstatus == 0) {
						parentname.append('<span class="oi envelope redhover addbookmarkemail" data-glyph="envelope-closed" title="Add an email alert to this bookmark" aria-hidden="true"></span>');
					}else {
						parentname.append('<span style="color:yellow;"class="oi envelope redhover removebookmarkemail" data-glyph="envelope-open" title="Remove the email alert from this bookmark" aria-hidden="true"></span>');
					}
					var alertreport = 'New email alert added';
					if(alertstatus == 0) {
						alertreport = 'Email alert removed';
					}
					$('#bookmarksinfomenu').append('<li class="standardli" style="border-radius: 3px;background-color:#6DD699;"><span class="oi removebookmarksinfo" style="position:relative;float:right;" data-glyph="x"></span><span class="oi" data-glyph="info" aria-hidden="true" style="color:#FFFFFF;"></span>' + alertreport + '</li>');
				}else {
					$('#bookmarksinfomenu').append('<li>' + response + '</li>');
				}
				$('#bookmarksinfomenu').removeClass('nodisplay');
			});
		});//(.addbookmarkemail) Add an email alert to an existing bookmark
		$('#newbookmarksmenu').on('click','.removebookmark',function(event) {
			event.stopPropagation();
			var parenttext = $(this).parents('.standardli').children('.recnote').text();
			var parentt = $(this).parents('.standardli');
			$.ajax({
				method:'GET',
				url: 'autocompleteportu2.php?bookmark=1&del=1&name=' + parenttext
			}).done(function(response) {
				
				if(response == "1"||response == 1) {
					parentt.remove();
					$('#bookmarksinfomenu').append('<li class="standardli" style="border-radius: 3px;background-color:#6DD699;"><span class="oi removebookmarksinfo" data-glyph="x" style="position:relative;float:right;"></span><span class="oi" data-glyph="info" aria-hidden="true" style="color:#FFFFFF;"></span>Bookmark removed</li>');
					$('#bookmarksinfomenu').removeClass('nodisplay');
				}else {
					$('#newbookmarksmenu').append('<li>' + response + '</li>');
				}
				//$('.spacer').remove();
			});
		});//(.removebookmark) Remove an email alert from an existing bookmark
		$('#newbookmarksmenu').on('click','.removebookmarksinfo', function() {
			$(this).parent().remove();
		});//(.removebookmarksinfo) Close the notification shown after removing/adding email alert
		$('#Bookmarksbubble').click(function() {
			$('#afterviewbookmarks').toggleClass('nodisplay');
		});
		$('#newbookmarksmenu').click(function(event){
			event.stopPropagation();
		});
		$('#afterviewbookmarks').on('click','#basesearch-edit',function(event){
			event.stopPropagation();
			
		});
		//---------------------------------------------------------------------------------------------------------------
	},//List of event listeners
	initobjects: function() {
		APP.timerstarted = false;
		APP.fontspecs= {
	fontsize:$('.spacerinp').css('font-size'),
	fontfamily:$('.spacerinp').css('font-family'),
	fontweight:$('.spacerinp').css('font-weight')
}
		APP.cmdpossibilities = [{cmdname:'Anciens',cmd:'PASDANCIEN'},{cmdname:'asr',cmd:/(asr[!]?=)|([!]?=asr)/},{cmdname:'AGENCE',cmd:'AGENCE',label:'<b>&#128101; '},{cmdname:'OWNER',cmd:'PART'},{cmdname:'BIENS',cmd:/(BIENS?)|(nat in)/},{cmdname:'ja',cmd:/(ja[<>=])|([<>=]ja)/},{cmdname:'p',cmd:/(p[<>=])|([<>=]p)/},{cmdname:'prix',cmd:/(prix[<>=])|([<>=]prix)/,label:'<b style="color:green;">&euro; '},{cmdname:'NOTES',cmd:'NOTES',label:'<b>&#128386; '},{cmdname:'MOT',cmd:'MOT'},{cmdname:'de',cmd:/(de[<>=])|([<>=]de)/,},{cmdname:'ville',cmd:/ville/},{cmdname:'s',cmd:/(s[<>=])|([<>=]s)/, label:'<b> '},{cmdname:'pr3',cmd:"pr3",label:'<b>&#128383; '},{cmdname:'date',cmd:'date',label:'<b>&#128336; '},{cmdname:'e',cmd:/(transac|VENTE|LOCATION|VIAGER|CHERCHE)S?/}];
		APP.PAKpossibilities = [{pak:'Anciens',reg:'PASDANCIEN'},{pak:'Transaction',reg:/(VENTES)|(VIAGES)/},{pak: 'Annonceur',reg: /(PART)|(PROF)/}];
		$('head').append('<link href="/body_a/open-iconic/font/css/open-iconic.css" rel="stylesheet">');
/*Save file menu HTML*/
	}//Append dynamic content
};
APP.workers = {
	findText: function(word) {
		word=word.replace(/-\x28([^\x28\x29]*)\x29/g,'');
		word=word.replace(/[+]\x28([^\x28\x29]*)\x29/g,'$1');
		word=word.replace(/([-+]?)\x22([0-9a-zA-Z\xE0-\xFF\xC0-\xDD]+)\x22/g,'$1$2');
		word=word.replace(/^[^0-9a-zA-Z\xE0-\xFF\xC0-\xDD]*([0-9a-zA-Z\xE0-\xFF\xC0-\xDD]+)[^0-9a-zA-Z\xE0-\xFF\xC0-\xDD]*$/,'$1');
		var plusnoquote=word.match(/[-+][0-9a-zA-Z\xE0-\xFF\xC0-\xDD]/)&&word.match(/^[^\x22]*$/)&&word.match(/[0-9a-zA-Z\xE0-\xFF\xC0-\xDD][ ]+[^ ]/);
		if(!word.match(/\x5B/)){ 
		if(plusnoquote){
		  word=word.replace(/[^0-9a-zA-Z\xE0-\xFF\xC0-\xDD]+/g,' ').replace(/^ | $/g,'');
		}
		word=word.replace(/-(\x22[^\x22]*\x22|[0-9A-Za-z\xE0-\xFF\xC0-\xDD]+)/g,'').replace(/[ ]{2,}/g,' ').replace(/^[ ]|[ ]$/g,'');
		word=word.replace(/\x22[0-9A-Za-z\xE0-\xFF\xC0-\xDD]+([ ]+[0-9A-Za-z\xE0-\xFF\xC0-\xDD]+)+\x22/g,function(m){return m.replace(/[ ]+/g,'\xF7');});
			
		word = word.replace(/[bdfghj-mp-tvwxz]/ig,function(match){return '['+match.toLowerCase()+match.toUpperCase()+']';}).replace(/[Cc\xC7\xE7]/g,'[Cc\xC7\xE7]').replace(/[Nn\xD1\xF1]/g,'[Nn\xD1\xF1]').replace(/[Ee\xC8-\xCB\xE8-\xEB]/g,'[Ee\xC8-\xCB\xE8-\xEB]').replace(/[Aa\xC0-\xC5\xE0-\xE5]/g,'[Aa\xC0-\xC5\xE0-\xE5]').replace(/[Ii\xCC-\xCF\xEC-\xEF]/g,'[Ii\xCC-\xCF\xEC-\xEF]').replace(/[Oo\xD2-\xD6\xF2-\xF6]/g,'[Oo\xD2-\xD6\xF2-\xF6]').replace(/[Uu\xD9-\xDC\xF9-\xFC]/g,'[Uu\xD9-\xDC\xF9-\xFC]').replace(/[Yy\xDD\xFD\xFF]/g,'[Yy\xDD\xFD\xFF]').replace(/[\xC6\xE6]/g,'(?:AE|ae|[\xC6\xE6])');//.replace(/,~,/g,'\xE7');
		}
		var wordreplace;
		  wordreplace = word.replace('"', '','g').replace(/^[ |]+|[ |]+$/g,'').replace(/[^-?:()\[\]0-9a-zA-Z\xE0-\xFF\xC0-\xDD]+/g,'(?![0-9a-zA-Z\xE0-\xFF\xC0-\xDD])|').replace(/^[ |]*/,'((?:^|[^0-9a-zA-Z\xE0-\xFF\xC0-\xDD])').replace(/[ |]*$/, '(?:[^0-9a-zA-Z\xE0-\xFF\xC0-\xDD]|$))').replace(/[\xF7]+/g,'[^0-9a-zA-Z\xE0-\xFF\xC0-\xDD]+').replace('(?:^|[^0-9a-zA-Zà-ÿÀ-Ý])(?![0-9a-zA-Zà-ÿÀ-Ý])|','');
		$('.noscroll2').each(function() {
			var text = $(this).children('div').children('span').text().replace('<','&lt;','g');
			var textmatch = new RegExp(wordreplace, 'g');
			text = text.replace(textmatch,'<span style="background-color:yellow;">$1</span>','g');
			$(this).children('div').children('span').html(text);
		});
		//APP.workers.functionlog('findText',APP.workers.findText);
	},
	sortPAK: function(item) {
		var separator = '';
		var newstring = '';
		if(item.length > 0) {
			newstring = '<div class="bookmark-desc" style="color:rgb(102, 102, 102)">';
			for(var i=0;i<item.length;i++) {
				var c = '';
				var mm = '';
				if(item[i].PakL !== ''){
					mm = item[i].PakL + ':';
				}
				//if(item[i].cat!==undefined&&item[i].cat!==null){
					c = 'qspacer-'+item[i].cat[0];
				//}
				newstring += '<div class="historyUniquecmd '+c+'"><span class="historyPakL">' + mm + '</span> ' + '<span class="historyPakR">' + item[i].PakR + '</span><span class="nodisplay historyCmd">' + item[i].Cmd + '</span><span class="nodisplay historycat">' + item[i].cat+ '</span><span class="nodisplay historycmdn">' + item[i].cmdn + '</span></div>';
			}
			newstring += '</div>';
		}
		return newstring;
	},
	timeConverter: function(UNIX_timestamp){
		var time = [];
		var a = new Date(UNIX_timestamp*1000);
		var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		if(top.selectim.LANG) {
			if(top.selectim.LANG=='Pt'){months = ['Janeiro','Fevereiro','Mar&#231;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];}
			if(top.selectim.LANG=='Fr'){months = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','decembre'];}
		}
		var year = a.getFullYear();
		var month = months[a.getMonth()];
		var date = a.getDate();
		var hour = a.getHours();
		var min = a.getMinutes();
		if(min < 10) {
			min = '0' + min;
		}
		time[0] = hour + ':' + min;
		time[1] = date + ' ' + month + ', ' + year;
		time[2] = date + '_' + month + '_' + year;
		return time;
	},
	httpGet: function(theUrl){
		var xmlHttp = null;
		xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", theUrl, false );
		if(xmlHttp.timeout){
			xmlHttp.timeout = 35000;
		}
		if(xmlHttp.ontimeout){
			xmlHttp.ontimeout = function () {
				alert('timed out!');
			}
		}
		xmlHttp.send();
		return xmlHttp.responseText;
	},//Basic XMLHTTP function
	getNewOutput: function () {
		var output = [];
		$('.truval').each(function(){
			var m = $(this).siblings('b').text().replace(/[:]/g,'')+';'+$(this).siblings('.spacerinp').val()+';'+$(this).parents('.spacer').attr('class').replace(/[^0-9]*/g,'')+';'+$(this).siblings('.spacerinp').attr('id');
			output.push(m);
		});
		return output.join(' AND ');
	},
	getOutput: function() {
		var output = [];
		var PAKarray = [];
		if($("#APPdate").length == 0) {
			output[0] = "21J<=date";
		}else{
			output[0] = $("#truvaldate").text();
			PAKarray.push($("#truvaldate").siblings('b').text() + ' ' + $("#truvaldate").siblings('.spacerinp').val());
		}
		$( ".truval:not(#truvaldate)" ).each(function( index ) {
			if($(this).siblings('.spacerinp').val()!=""){
				output[0] += " AND " + $(this).text();
				//output[1] += " AND " + $(this).siblings('b').text() + ' ' + $(this).siblings('.spacerinp').val();
				PAKarray.push($(this).siblings('b').text() + ' ' + $(this).siblings('.spacerinp').val());
			}else{
				$(this).parent().remove();
			}
		});
		if(PAKarray.length > 1) {
			var newpak = PAKarray.join(' AND ');
		}else {
			newpak = PAKarray[0];
		}
		output[1] = newpak;
		//APP.workers.functionlog('getOutput',APP.workers.getOutput);
		return output;
	},//Assemble the search URL parameters to send to server
	keyupFunction: function(source) {/*-----------------------------autocomplete ajax*/
		var oldpak= '';
		if(typeof(APP.oldpak)!="undefined"&&APP.oldpak!=''){
			oldpak= "&oldpak="+APP.oldpak[1]+"&oldcmd="+APP.oldpak[0];
		}
		if(typeof(source=="Object")) {
			APP.source = source.attr("id");
		}else{
			APP.source = source;
		}
		var cmdname = 'cmdname=' + APP.source.replace('APP','');
		if(APP.source == "APP-input") {
			cmdname = '';
		}
		var x = "portu2";if(typeof(window.PAYS)!="undefined"){if(window.PAYS=="fr"){x="fr1";}}
		var p = ((APP.source=="searchbar-ville")&&(cmdname = 'cmdname=ville')?"v "+source.val():source.val());
			if(p.length >= 1) {
			window.ijuststartedaget+=1;
		var bef=new Date().getTime();
				$.getJSON("autocomplete"+x+".php?" + cmdname + oldpak,
				{"term":p,"cmds":APP.workers.getOutput()[0]},
				function( data ) {
					var m = 0;
					var cmdnamesave= '';
					var PAKq = '';
					window.ijustfinishedaget=p;
					for(item in data){
						if(data[item].dis.match(/[*]/)){
							var cm = data[item].cmdname;
							cmdnamesave = data[item].cmdname;
							PAKq = data[item].PAK;
							var t = data[item].dis.match(/(?:<b>)([^<]*)</);
							var gg = [data[item].cmdname,data[item].cmd,t[1],PAKq,data[item].cat];
							m += 1;
						}
					}
						if(m>=1){
							if(window.spacetrigger==1){
										window.spacetrigger=0;
								if($('#APP' + cm).length) {$('#APP' + cm).parent().remove();}
								//$(gg).insertBefore('#APP-inputcase');
								//$('#APP' + cmdnamesave).val(PAKq);
								APP.workers.insertSpacer(gg[0],gg[1],gg[2],gg[3],gg[4]);
								APP.input.val('');
								$('.APP-locbox table tr').remove();
								$('.APP-menu').addClass('hidden');
								//APP.input.focus();
							}else{
								$('body').on('keyup','#APP-input',function dee(event){
									if(event.which==32){
										if($('#APP' + cm).length) {$('#APP' + cm).parent().remove();}
										//$(gg).insertBefore('#APP-inputcase');
										//$('#APP' + cmdnamesave).val(PAKq);
										APP.workers.insertSpacer(gg[0],gg[1],gg[2],gg[3],gg[4]);
										APP.input.val('');
										$('.APP-locbox table tr').remove();
										$('.APP-menu').addClass('hidden');
										//APP.input.focus();
									}
									window.spacetrigger=0;
									$('body').off('keyup','#APP-input',dee);
								});
							}
						}
						if(typeof(data) == "object") {
							data.sort(function(a,b){return a.pri - b.pri});
							data.reverse();
						}
						window.ijuststartedaget-=1;
						window.spacetrigger=0;
						APP.debugJSON=data;
						APP.workers.suggest(data);
				});
		APP.timerstarted = false;
		var now=new Date().getTime();now=now-bef;
		}
		return;
	},//JSON request function for autocomplete suggestions
	suggest: function(data) {/*----------------------------------Append li for each JSON item*/
		$('.APP-locbox').off('mouseover',APP.workers.locmove);
		var p=$('#APP-input').val();
		var ttt=new RegExp("("+escapeRegExp(p)+".*)","i");
		//$(".APP-locbox table tr").remove();
		$('.APP-locbox').remove();
		var v = '#APP-input';
		if($('#'+APP.source).length){
			v = '#'+APP.source;
		}else if($('.'+APP.source).length){
			v = '.'+APP.source;
		}
		$('<div class= "APP-menu APP-locbox hidden"style="overflow-y:scroll;margin:0;padding:0;"><table style="border-spacing:0px;margin-left:3px;border-collapse:collapse;"></table></div>').insertAfter(v);
		if(data != null && data.length > 0) {
				var mm = new RegExp(/\u00a4/g);
				var hghg = "&#164;";
				for(x=0;x<data.length;x++) {
					data[x].dis.replace(mm,hghg);
					if(x==0&&p.length>=3&&data[x].PAK.match(ttt)){
						var q=data[x].PAK.match(ttt);
						var www=p+q[1].slice(p.length)
						www=www.replace(/[()]/ig,'');
						if(www.length <=100) {$('#ghost').val(www);}
					}
					if(data[x].dis.match(/^<tr/i)&&data[x].dis.match(/[\x2F]tr>/i)){
						$(data[x].dis).appendTo(".APP-locbox table");//<div style="min-width:100px; width: auto !important; width: 100px;">
					}else{
						var reptr=data[x].replace(/<[\x2F]?tr>/g,'');
						$('<tr>'+reptr+'</tr>').appendTo('.APP-locbox table');
					}
				}
				/*if(data.length > 25) {
					var winwin = window.innerHeight * .60;
					$('.APP-locbox').css("height", winwin);
				}else {
					$('.APP-locbox').css("height","auto");
				}*/
				$('.APP-locbox').removeClass("hidden");
				//$('.APP-locbox').scrollTop(0);
				//APP.workers.resetListeners('.APP-locbox');
				//APP.workers.placeLocbox(APP.source);
				//$('.taken').removeClass('taken');
				$('.APP-locbox tr:first-child').addClass("taken");
				$('.APP-locbox').on('mouseover','tr',APP.workers.locmove);//Mouseover add Taken
		return;
		}
	},//JSON response function for autocomplete suggestions; event listener for adding new searchterms from list
	resetListeners: function(arg) {
		//$('.APP-menu').css("position","absolute");
        $(".APP-menu").click(function(event) {
        	event.stopPropagation();
        });
		if(!APP.source) {
			APP.source = 'APP-input';
		}
		//var offsetauto = $("#" + APP.source).parent().position();
		var offsetauto = $('.textbox').position();
		var spatex = $('.spacer_textarea').not('.nodisplay');
		if(typeof(spatex)!="undefined"&&spatex.length>0){
			$(arg).css({
				"top": spatex.position().top + spatex.height()
			});
		}else{
			$(arg).css({
				"left": offsetauto.left,
				"top": offsetauto.top+50
			});
        }
        //APP.workers.functionlog('resetListeners',APP.workers.resetListeners);
	},//reset the absolute position of the autocomplete menu
	placeLocbox: function(a) {
		$('.APP.locbox').css({
			"left":a.position().left,
			"top":a.position().top+a.height()
		});
	},
	scrollFunction: function() {
		var qq = $(".colspanscroll").height();
		if(APP.currentpage < APP.pagecount) {
			$(".colspanscroll").text('').css("height",qq);
			$(".colspanscroll").addClass("loadinggif");
		}
		var wintop = $(window).scrollTop();
		APP.wintop=wintop;
		var appheight = $("#APP-inpcase").height();
		var inppos = $("#APP-menubaroptions").position();
		if(wintop > APP.initpos) {
			$('#APP-handlebar').parent().removeClass('nodisplay');
			if(!($('#dynputdiv').hasClass('t-fixed')) ){
				$('#dynputdiv').css({'position':'fixed','top':'0'}).addClass('t-fixed');
			}
			if(!$('#APP-handlebar').hasClass('APP-toggled')){
				if(!$('#APP-handlebar').hasClass('APP-useractive')){
					APP.workers.handlebar();
				}
			}
		}
		if(wintop < APP.initpos) {
			$('#APP-handlebar').parent().addClass('nodisplay');
			$('#dynputdiv').css('position','relative').removeClass('t-fixed');
			if($('#APP-handlebar').hasClass('APP-toggled')){
				APP.workers.handlebar();
				$('#APP-handlebar').removeClass('APP-useractive');
			}
		}
		clearTimeout( $.data( this, "scrollCheck" ) );
		$.data( this, "scrollCheck", setTimeout(function() {
			var wintop1 = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();
			var scrolled = wintop1/(docheight-winheight)*100;
			if(wintop1 + winheight >= $(".colspanscroll:last-child").position().top) {//!$('#emptysearch')&&
			//if(scrolled >= 60 ) {
				if(APP.currentpage <= APP.pagecount) {
					APP.workers.adCall('scroll',($('.truval').length?APP.openurl:window.uri1),Number(APP.currentpage+1));
				}
			}
		}, 500) );
	},
	encodeFunction: function(data) {
		//var modi = encodeURI(data).replace('+','%2B','g') + encodeURIComponent('+<>?%&=');//.replace(/[ ]/,'%20','g').replace('<','%3C','g').replace('>','%3E','g');
		var modi = data.match(/^([^?]*)[?](.*)$/);
		var result = modi[1] + '?';
		var sep = '';
		var each = modi[2].split('&');
		for(i=0;i<each.length;i++){
		     var nm = each[i].match(/^([^=]*)[=](.*)$/);
			result += sep +nm[1]+'='+ encodeURIComponent(nm[2]);
			sep= '&';
		}
		//APP.workers.functionlog('encodeFunction',APP.workers.encodeFunction);
		return result;
	},
	getWidth: function(element) {
		var elemWidth = 0;
		var maxWidth = 0;
		element.each(function() {
			if( $(this).width() > elemWidth) {
				elemWidth = $(this).width();
			}
		});
		if(elemWidth == 0) {
			element.each(function() {		
				var m = $(this).text();	
				if( m.length > elemWidth) {
					elemWidth = m.length * 5;
				}
			});
		}
		maxWidth = elemWidth;
		return maxWidth;
	},
	noscroll2Function: function() {
		if($(this).css("overflow-y") == "hidden") {
			$(this).css({"overflow-y":"visible"});
			var width = $(this).width();
			var parentwidth = $(this).parent().width();
			$(this).children().css({"position":"absolute","z-index":"1000","box-shadow":"10px 10px 5px #888888","width":width,"background-color":"#f4e7e7"});
			$(this).children().height("auto");
			$(this).parent().width(parentwidth);
		}else {
			$(this).css({"overflow-y":"hidden"});
			$(this).children().css({"position":"relative","z-index":"initial","background-color":"initial","box-shadow":"none"});
		}
	},//Expandable text for description category of search results
	checkNewTickets: function() {
		var unviewed = 0;
		$.getJSON("autocompleteportu2.php?support=1&supportlist=1&unviewed=1", function( response ) {
			unviewed = response[0][0].nb;
		}).done(function() {
			if(unviewed > 0) {
				$('#APP-menubaroptions').append('<div id="APP-viewcount" style="position:absolute;background-color:red;color:white;border-radius:50%; text-align:center; width:12px;height:12px;font-size:x-small;cursor:default;">' + unviewed + '</div>');
				$('#APP-viewcount').css({
					left: $('#supportbtn').position().left,
					top: $('#supportbtn').position().top
				});
			}
		});
	},
	checkBookmarks: function() {
		var checkalertemail = function( input ) {
			var email = '<span class="oi envelope redhover addbookmarkemail" data-glyph="envelope-closed" title="'+lng('Adicionar um alerta de e-mail para este bookmark','Pt')+lng('Add an email alert to this bookmark','En')+lng('Ajouter une alerte e-mail à ce bookmark','Fr')+'" aria-hidden="true"></span>';
			if( input == '1') {
				email = '<span class="oi envelope redhover removebookmarkemail" data-glyph="envelope-open" style="color:yellow;" title="'+lng('Retirar alerta e-mail de este bookmark','Pt')+lng('Remove email alert from this bookmark','En')+lng('Retirer une alerte de ce bookmark','Fr')+'" aria-hidden="true"></span>';
				//email = '<img src="/body_a/open-iconic/envelope-closed.svg" alt="envelope-closed"height="20" width="30">';
			}
			return email;
		}
		$.getJSON("autocompleteportu2.php?support=1&supportlist=1", function( data ) {
			var euro = JSON.stringify(data).replace(/[\u0080]/g,'\u20AC');
			var response = JSON.parse(euro);
			var basesearch='';
			var pvp='';
			if(response.length>1) {
				response = response[1];
				$('#afterviewbookmarks li').remove();
				for(i=0;i<response.length;i++) {
					pvp=response[i].recnote.split('"').join('');
					pvp=pvp.split('AND');
					var title='';
					for(m=0;m<pvp.length;m++){
						var titlesplit = pvp[m].split(';');
						title+='<div class="qspacer-'+titlesplit[2]+'"><b>'+titlesplit[0]+':</b> '+titlesplit[1]+'</div>';
					}
						$('#afterviewbookmarks ul').append('<li class="standardli"><span style="position:relative;float:right;"><span style="margin-right:3px;"class="oi redhover removebookmark" data-glyph="circle-x" aria-hidden="true" title="'+lng('Excluir bookmark','Pt')+lng('Delete bookmark','En')+lng('Effacer bookmark','Fr')+'"></span><span>' + checkalertemail(response[i].alerte) + '</span></span><span class="recnote">' + response[i].rec + '</span><span class="alertlistcmd nodisplay">' + response[i].sel + '</span><span class="alertlistPAK nodisplay">' + response[i].recnote + '</span><div class="bookmark-desc">'+title+'</div></li>');
				}
				$('#afterviewbookmarks ul').prepend(basesearch);
			}
			if($('#afterviewbookmarks li').length) {
				$('#bookmarkthissearch').removeClass('nodisplay');
			}
		});
	},
	initializeHistory: function() {
		var temparray = [];
		for(item in APP.SEARCHIS) {
			temparray.push([item,APP.SEARCHIS[item]]);
		}
		temparray.sort(function(a,b){return a[1].Tim - b[1].Tim});
		temparray.reverse();
		for(i=0;i<temparray.length;i++) {
			if($('.' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[2]).length) {
				$('.' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[2]).append('<li class="historyitem" style="color:#FFFFFF;">' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[0] + ' ' + APP.workers.sortPAK(temparray[i][1].PakCmd) + '</li>');
			}else {
				$('.historymenu').append('<ul style="list-style:none;margin:0;padding-left:0;"class="' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[2] + '"><li style="text-align:center;cursor:pointer;margin:3px;border:1px solid rgb(137, 137, 137)"><span class="carettoggle">&#9660;</span>  ' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[1] + '</li><li class="historyitem" style="color:#FFFFFF;">' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[0] + ' ' + APP.workers.sortPAK(temparray[i][1].PakCmd) + '</li></ul>');
			}
		}
	},
	adCall: function(fromwhere,caddie,pagenum){
		if(fromwhere=="scroll"&& APP.currentpage >= APP.pagecount){return 0;}
		$('html').addClass('wait');
		if(fromwhere!="scroll"&&fromwhere!="telclick"&&fromwhere!="bin"&&fromwhere!="euroavg"&&fromwhere!="caddie"&&fromwhere!="notes"){$("#resultats tr").remove();}
		if(fromwhere=="gotopg"||fromwhere=="x"||fromwhere=="phonereturn"||fromwhere=="init"){APP.loadertable.insertAfter('#resultats tr:first-child');}
		if(fromwhere=="scroll"){
			var qq = $(".colspanscroll").height();
		 		if(APP.currentpage < APP.pagecount) {
		 			$(".colspanscroll").text('').css("height",qq);
		 			$(".colspanscroll").addClass("loadinggif");
		 		}
		}
		var lg = 'pt';
		if(top.selectim.LANG){lg=top.selectim.LANG.toLowerCase();}
		var orderwhere='';
		//console.log(typeof(APP.orderwhere)!='undefined'?'Order is set as /'+APP.orderwhere+'/':'APP.orderwhere is undefined');
		if(fromwhere!="order"&&fromwhere!="scroll"){
			delete APP.orderwhere;
		}
		var tydata = {x:'1024',y:'768',z:'0',MAC:'0',ass2calm:'0',gotck:'1',recec:'0',lg:lg,inframe:'1',wheresi:'245',where:caddie,PAGE:pagenum,VIDECADDIE:(fromwhere=="videcaddie"?"1":"0"),moy:(fromwhere=="euroavg"?"1":"0")};
		if(fromwhere=="init"||fromwhere=="telclick"||fromwhere=="videcaddie"){tydata.PAK="";}else{tydata.PAK=APP.workers.getOutput()[1];}
		if(typeof(APP.orderwhere)!="undefined"){tydata.order=APP.orderwhere.replace(/^(NaN)?(order=)?/,'');}
		if(fromwhere=='telclick'||fromwhere=="bin"||fromwhere=="caddie"||fromwhere=="notes"){tydata.lbx="1";}
		var request = $.ajax({
			dataType: "json",
			url: 'index.php',
			data: tydata,
			success: function( jayson ) {
				$('#loadertable').remove();
				$(".colspanscroll").removeClass("loadinggif");
    			$(".pgnum").removeClass("loadinggif");
				if(fromwhere=='telclick'||fromwhere=="bin"||fromwhere=="caddie"||fromwhere=="notes"){APP.workers.telclick(jayson,fromwhere,decodeURIComponent(caddie));return;}
				if(fromwhere=="euroavg"){
					$("#euroavg").html(lng('Pre&#231;o','Pt')+lng('price','En')+lng('prix','Fr')+" / m2 "+lng('m&#233;dio de ','Pt')+lng('average of ','En')+lng('moyenne de ','Fr')+ jayson.W_nbr +lng(' an&#250;ncio','Pt')+lng(' ad','En')+lng(' annonce','Fr')+ (jayson.rows>1?"s":"")+": " + jayson.W_ave);
					$('html').removeClass('wait');
					return;
				}
				if(typeof(jayson.table)=="undefined"||jayson.table.length<1){
					$("#resultats tbody").append('<tr><td id="emptysearch"colspan="9"style="text-align:center;font-size:3em;">'+lng('Disconnected','Pt')+lng('Disconnected','En')+lng('Disconnected','Fr')+'</td></tr>');
					return;
				}
				if(jayson.table !== "0 AD") {
					if(fromwhere!=="scroll"&&fromwhere!=="gotopg"){APP.currentpage=1;}
					APP.pagecount = (jayson.rows ? 1 + Math.floor((jayson.rows - 1) / jayson.W_PARPAGE):'');
					$("#resultats").append(jayson.table);
					if(fromwhere=="scroll"){
						var pgnuu = $(".colspanscroll:last-child");
						pgnuu.removeClass("colspanscroll").addClass("pgnum").text(lng('pagina','Pt')+lng('page','En')+lng('page','Fr')+" " + Number(APP.currentpage+1));
						pgnuu.parent().next().remove();
					}
					if(fromwhere!=="caddie"){$("#resultats").append('<tr><td colspan="9" class="colspanscroll" id="pagina' + Number(APP.currentpage + 1) + '">'+((APP.currentpage+1)<APP.pagecount?(lng('clique para mais resultados','Pt')+lng('Click for more results','En')+lng('cliquez pour plus de résultats','Fr')):(lng('Acabado','Pt')+lng('Finished','En')+lng('Fin','Fr')))+'</td></tr>');}
					$("#APP-adnumber").html(jayson.rows +lng(' an&#250;ncio','Pt')+lng(' ad','En')+lng(' annonce','Fr')+(jayson.rows>1?"s":""));
					if(jayson.W_nbr > 0) {
						$("#euroavg").html(lng('Pre&#231;o','Pt')+lng('price','En')+lng('prix','Fr')+" / m2 "+lng('m&#233;dio de ','Pt')+lng('average of ','En')+lng('moyenne de ','Fr')+ jayson.W_nbr +lng(' an&#250;ncio','Pt')+lng(' ad','En')+lng(' annonce','Fr')+ (jayson.rows>1?"s":"")+": " + jayson.W_ave);
					}
					if(!$('.textbox').hasClass('nodisplay')||fromwhere=="init"){$('#APP-pgnumber').removeClass('nodisplay').removeClass('hidden');}
					if(fromwhere=="scroll"){
						APP.currentpage+=1;
					}
					if(fromwhere!="init"){
						if(APP.expanded == 1||$('#APPMOT').length) {
							$('.noscroll2').css({ "height":"auto", "overflow":"auto" }); 
							$('.textexp').text('[--]');
							$('.textex').addClass('nodisplay');
						}
					}
					if(fromwhere=="init"){
						if(typeof(jayson.AUTOPAK)!="undefined"){
							var ap = jayson.AUTOPAK;
							for(i=0;i<ap.length;i++){
								var check = 0;
								for(item in ap[i]){
									if(typeof(ap[i][item])=="undefined"||typeof(ap[i][item])=="null"){
										check +=1;
									}
								}
								if(check==0){
								APP.workers.insertSpacer(ap[i].cmdn,ap[i].Cmd,ap[i].PakL,ap[i].PakR.replace(/^[ ]?[a-z][ ]/,''),ap[i].cat);
								}
							}
							$('#APP-recnote').text('Mon secteur');
						}
					}
				}else{
					$("#resultats tbody").append('<tr><td id="emptysearch"colspan="9"style="text-align:center;font-size:3em;">'+lng('Nenhum resultado encontrado','Pt')+lng('No results found','En')+lng('Aucune annonce','Fr')+'</td></tr>');
						//$("#resultats tbody").append('<tr><td id="emptysearch"colspan="9"style="text-align:center;font-size:3em;">'+jayson.rows+" "+lng('resultado','Pt')+lng('result','En')+lng('résultat','Fr')+(jayson.rows>1?"s ":" ")+lng('não mostrado','Pt')+lng('removed','En')+lng('pas montré','Fr')+'</td></tr>');
						$('#APP-pgnumber').removeClass('nodisplay');
						$("#APP-adnumber").html(jayson.rows +lng(' removido','Pt')+lng(' removed','En')+lng(' supprimé','Fr'));
						APP.pagecount = (jayson.rows ? 1 + Math.floor((jayson.rows - 1) / jayson.W_PARPAGE):'');
						APP.currentpage = 1;
				}
				$('#APP-gotopg').val(APP.currentpage);
				$('#APP-totpage').text(APP.pagecount);
				if(APP.pagecount>1){
					$('#APP-sinvis').removeClass('nodisplay');
				}else{
					$('#APP-sinvis').addClass('nodisplay');
				}
				if(fromwhere=="x"){
					var bookmarktext = '';
					$('.spacer').each(function(){
						var c = $(this)[0].className.match(/spacer-00[0-9]/);
						bookmarktext += '<div class="'+(c?c:'')+'"><b>' + $(this).children('b').text() +'</b>'+ $(this).children('input').val() + "</div>";
					});
					$('#createanewbookmarktgle').html(lng('criar um novo bookmark com a busca','Pt')+lng('Create a new bookmark with the search','En')+lng('Creéz un nouveau bookmark avec la recherche','Fr')+':<br><div class="bookmark-desc">' + bookmarktext + '</div>');
					$('#createanewbookmarktgle').css('overflow-x','auto');
					$('#createanewbookmarktgle').removeClass('nodisplay');
					$("#bookmarkthissearch").removeClass("nodisplay");
					if(jayson.table=="0 AD"){
						$('#confirmnewbookmarkbtn').data('valid','0');
					}else{
						$('#confirmnewbookmarkbtn').data('valid','1');
					}
				}
				if(fromwhere=="init"){
					if(typeof(jayson.JSON_LIENS['DownloadCSV'])=="string"){
						$('#csv').data('lien',jayson.JSON_LIENS['DownloadCSV']);
					}
					if(typeof(jayson.JSON_LIENS['DownloadEXL'])=="string"){
						$('#excel').data('lien',jayson.JSON_LIENS['DownloadEXL']);
					}
					$('.APP-caddie-menu li:first-of-type').data('PAK',jayson.JSON_LIENS['Caddie_PAK']).data('cmd',jayson.JSON_LIENS['Caddie_cmd']);
					if(typeof(jayson.JSON_LIENS['ClicSecteur'])=="string"){
						$('.APP-user-menu li:nth-child(2)').attr('onclick',jayson.JSON_LIENS['ClicSecteur']);
					}
					var newcad = jayson.JSON_LIENS['Caddie_cmd'].replace(/and[ ]?NOTA[=].*/,'');
					var newcad1 = jayson.JSON_LIENS['Caddie_cmd'].replace(/(and[ ]?NOTA[=]).*/,'$1');
					$('.APP-caddie-menu li:nth-child(3)').data('cmd', newcad);
					$('.APP-caddie-menu li:nth-child(4)').data('cmd', newcad1);
				}
				if(typeof(jayson.secs)!="undefined"){
						$('#APP-secs').text(lng('Search concluída em','Pt')+lng('Search completed in','En')+lng('Recherche faite en','Fr')+": "+jayson.secs+' '+lng('segundos','Pt')+lng('seconds','En')+lng('secondes','Fr'));
					}
				if(typeof(jayson.recname)!="undefined"&&jayson.recname.length>0){
					$('#APP-recnote').text(jayson.recname);
				}
				if(typeof(jayson.REPORT) !='undefined') {
					var b = $('.REPORT').parent();
					var cla=$('.REPORT').attr('class');
					$('.REPORT').remove();
					b.append(jayson.REPORT);
					$('.REPORT').addClass(cla);
				}
				if(fromwhere!="scroll"){
				$('.historymenu li').remove();
				$('.historymenu ul').remove();
				$('#dbghistorymenu li').remove();
				$('#dbghistorymenu ul').remove();
				var stringified = JSON.stringify(jayson);
				stringified=stringified.replace(/\u00a4/ig,'\u20ac');
				var jaysonb=JSON.parse(stringified);
				APP.workers.generateHistory(jaysonb.SEARCHIS,0);
				if(typeof(jaysonb.DbgSEARCHIS)!="undefined"){APP.workers.generateHistory(jaysonb.DbgSEARCHIS,1);}
				}
				if($("#APPMOT").length) {
					APP.workers.findText($("#APPMOT").val());
				}
				if($('#truvalville').length&&$('#truvalville').text().match(/MOT=["][\x60]([^\x60]*)[\x60]/)){
					var magix = $('#truvalville').text().match(/MOT=["][\x60]([^\x60]*)[\x60]/);
					APP.workers.findText(magix[1]);
				}
				if(!$('.historyUniquecmd').length){
					$('#searchhistorymenu').addClass('nodisplay');
				}else{
					$('#searchhistorymenu').removeClass('nodisplay');
				}
				$('html').removeClass('wait');
			},
			timeout: 35000,
			error: function(xhr, status) {
				if( status == "timeout" ) {
					$('#loadertable').remove();
					$("#resultats tbody").append('<tr><td id="emptysearch"colspan="9"style="text-align:center;font-size:3em;">'+lng('Solicitação expirou','Pt')+lng('Request Timed out','En')+lng('Temps de réponse expiré','Fr')+'</td></tr>');
				}
			}
		});
		$('#initloader').remove();
	},
	/*adCall1: function(source,urlA,pageA,pakA){
		$.ajax({
			dataType: "json",
			url: 'index.php',
			data:{x:'1024',y:'768',z:'0',MAC:'0',ass2calm:'0',gotck:'1',recec:'0',lg:lg,inframe:'1',wheresi:'245',where:urlA,PAGE:pageA,PAK:pakA},
			success:function(jayson){
			},
			timeout: 35000,
			error:function(xhr, status) {
				if( status == "timeout" ) {
					$('#loadertable').remove();
					$("#resultats tbody").append('<tr><td id="emptysearch"colspan="9"style="text-align:center;font-size:3em;">'+lng('Solicitação expirou','Pt')+lng('Request Timed out','En')+lng('Demande a expiré','Fr')+'</td></tr>');
				}
			}
		});
	}*/
	respace: function() {
		if(APP.respacecounter){
		APP.respacecounter+=1;
		}else{
		APP.respacecounter=1;
		}
		if(APP.respacecounter>200){
			return false;
		}
		$('.textbox br').remove();
		var count = 0;
		$('#APP-inputcase').width(0);
		$('.spacer').each(function(){
			if($(this).width()>=950){
				$(this).width(200);
			}
			if($(this).offset().left+$(this).width()>950){
				$('<br>').insertBefore($(this));
			}
		});
		
		var r = $('#APP-inputcase').offset().left;
		if(r>900){
			$('<br>').insertBefore($('#APP-inputcase'));
		}
		var wid=950-Number(r);
		$('#APP-inputcase').width(wid);
		$('#APP-input').css('width','100%');
		APP.respacecounter-=1;
		return;
	},
	measureText: function(txt,font) {
		if(typeof(font)=="undefined"){
			font = APP.fontspecs;
		}
		if(typeof(font.fontfamily)=="undefined"||font.fontfamily=="undefined"){font.fontfamily='arial,helvetica,sans serif,sans,verdana'}
		if(typeof(font.fontsize)=="undefined"||font.fontsize=="undefined"){font.fontsize=$('body').css('font-size')}
		var id = 'text-width-tester',
			$tag = $('#' + id);
		if (!$tag.length) {
			$tag = $('<span id="' + id + '" style="display:none;font-size:'+font.fontsize+';font-family:'+font.fontfamily+';font-weight:'+font.fontweight+'">' + txt + '</span>');
			$('body').append($tag);
		} else {
			$tag.css({
				"font-size":font.fontsize,
				"font-family":font.fontfamily,
				"font-weight":font.fontweight
			});
			$tag.text(txt);
		}
		if($tag.width()<=200){
			return $tag.width();
		}else{
			return 200;
		}
	},
	ghostSuggest: function(that) {
		if((typeof(APP.source)!="undefined"&&APP.source==('APP-input'||APP.input))||typeof(APP.source)=="undefined"){
			var sourceval=$('#APP-input').val();
			var sourcereg= new RegExp('('+escapeRegExp(sourceval)+'.*)','i');
			var sourcheck=APP.debugJSON[that.index()].PAK.match(sourcereg);
			if(sourcheck&&$('#APP-input').val().length<=100){
				$('#ghost').val(sourceval+sourcheck[1].replace(/[()]/g,'').slice($('#APP-input').val().length));
			}
		}else{
			console.log((typeof(APP.source)!="undefined"?APP.source:"APP.source is undefined"));
		}
	},
	insertSpacer: function(id,pdata,title,PAK,cat,src){
		if(id=="de"){id="ville"}
		if(id=="ville"){
			APP.oldpak = [encodeURIComponent(pdata),encodeURIComponent(PAK)];
		}
		var notecase = '';
		if(id=="NOTES"){
			notecase = 'disabled="disabled"';
		}
		//PAK=PAK.replace('"','&quot;');
		if(typeof(src)=="undefined"){
			var src = '';
		}
		var len=20;
		id = id.replace(' ','');
		if(PAK.length<100){len=PAK.length;}
		var style='';
		var catclass='';
		var destination = '#APP-inputcase';
		if(typeof(cat)=="undefined"){
			cat = ['002','Le lieu','001','Lieu'];
		}
		if(typeof(cat)!="undefined"){
		if(typeof(cat)=="string"){
			cat=[cat];
		}
		catclass='spacer-'+cat[0];
		if($('.textbox .spacer-'+cat[0]).length > 1){destination='.textbox .spacer-'+cat[0]+':last';}
		}else{
			if($('.textbox .spacer-'+cat[0]).length){destination='.textbox .spacer-'+cat[0];}
		}
		if(!title.match(':')){
			title=title+': ';
		}
		var submenu = $('#plan-'+id).find('.plan-submenu');
		var spacetext = '<div class="nodisplay spacer_textarea '+(id=="ville"?"s-t-ville":"")+'" style="background-color:'+style+'"><div><b>'+title+'</b></div><div class="spacerinp-textarea-toggle" style="text-align: right; display: inline-block; float: right; position: absolute; left: 95%; top: 5px; background-color: rgb(210, 210, 210); padding: 1px 3px; cursor: pointer;">x</div><textarea>'+PAK+'</textarea></div>';
		if(submenu.length&&id!="ville"){
			spacetext = '';
		}
		$('<span class="spacer '+catclass+'" style="'+'background-color:'+style+'"> '+spacetext+'<b>'+title+'</b><input '+notecase+' class="spacerinp '+((PAK.length>=30&&!submenu.length)||id=="ville"?'spacerinp_expand':'')+'" '+(submenu.length&&id!="ville"?'readonly="readonly" ':'')+'autocomplete="off" id="APP' + id +'" style="padding-left:0px;background-color:rgba(255,255,255,0);border:none;" value="'+PAK.replace(/["]/g,'&quot;')+'"></input><p class="truval nodisplay" id="truval' + id + '">'+pdata+'</p><div class="remove">x</div></span>').insertBefore($(destination));//size="'+len+'"
		if(id!="ville"){
			submenu.clone().appendTo($('#APP'+id).parent()).addClass('hidden');
		}
		var n = PAK.length;
		if(n<30) {
			//$('.textbox .spacer:last-of-type').children('.spacerinp').attr("size",n);
			var fontspecs= {
				fontsize:$('.spacerinp').css('font-size'),
				fontfamily:$('.spacerinp').css('font-family'),
				fontweight:$('.spacerinp').css('font-weight')
			}
			$('#APP'+id).css("width", APP.workers.measureText(PAK,fontspecs)+20);
		}else {
			$('#APP'+id).attr("size","30").css("width", "auto").attr('title',PAK);
			$('#APP'+id).parent().addClass('spacer_expand');
			//$('.textbox .spacer:last-of-type').children('.spacerinp').attr('tooltip_data',$('.textbox .spacer:last-of-type').children('.spacerinp').val());
			$('<b class="elipse" style="font-size:large;">...</b>').insertAfter($('#APP'+id));
		}
		$('#APPville').addClass('spacer_expand');
		if(src!='oldput'){
			APP.workers.fillQuadbar(pdata,id,src,PAK,catclass);
		}else{
			$('#plan-'+id+' input').addClass('filled');
			if(id=="ville"){
				$('#plan-ville input').val(PAK);
				$('#plan-ville-textarea').val(PAK);
			}
		}
		$("#APP-recnote").text('');
		setTimeout("APP.workers.respace();",10);
		$('#APP-clear-all').addClass('clear-plan-filled');
	},
	fillQuadbar: function(pdata,id,src,PAK,catclass){
		//(typeof(src)!=="undefined"&&src=="dynam"?'visibility:hidden;':'')+
		var test = 10;
		var safepdata=pdata.replace(/[^A-Za-z]*/g,'');
			switch(id){
				case 'asr':
					$('#plan-asr input').val(PAK);
					break;
				case 'an':
				case 'MODERNE':
					$('#plan-an input').val(PAK);
					break;
				case 'MOT':
					$('#plan-MOT').find('input').val(PAK.replace(/^["]?([a-z][ ])?([^"]*)["]?/,"$2")).addClass('filled');
					$('#plan-MOT-textarea').val(PAK.replace(/^["]?([a-z][ ])?([^"]*)["]?/,"$2"));
					break;
				case 'date':
					$('#plan-'+id).find('input').val(PAK.replace(/^["]?([a-z][ ])?([^"]*)["]?/,"$2")).addClass('filled');
					break;
				case 'pr3':
					$('#plan-'+id).find('input').val(PAK.replace(/^["]?([a-z][ ])?([^"]*)["]?/,"$2")).addClass('filled');
					break;
				case 'de':
				case 'ville':
					$('#plan-ville').find('input').val(PAK.replace(/^["]?([a-z][ ])?([^"]*)["]?/,"$2")).addClass('filled');
					$('#plan-ville-textarea').val(PAK.replace(/^["]?([a-z][ ])?([^"]*)["]?/,"$2"));
					break;
				case 'BIENS':
					var nPAK=PAK.replace(/^[b][ ]/,'');
					$('#plan-BIENS input').val(nPAK);
					/*var nPAK=PAK.replace(/^[b][ ]/,'');
					$('#plan-BIENS input').val(nPAK);
					var r = new RegExp(/["]([^"]*)["]/,'ig');
					var b = pdata.match(r);
					for(i=0;i<$('#plan-BIENS .plan-submenu tr').length;i++){
						if($('#plan-BIENS .plan-submenu tr').eq(i).data('pdata')){
							for(v=0;v<b.length;v++){
								b[v]=b[v].replace(/["]/g,'').toLowerCase();
								if($('#plan-BIENS .plan-submenu tr').eq(i).data('pdata')==b[v]){
									$('#plan-BIENS .plan-submenu tr').eq(i).addClass('reserved');
									$('#APPBIENS').siblings('.plan-submenu').find('tr').eq(i).addClass('reserved');
								}
								console.log(v);
							}
						}
					}
					$('#plan-BIENS input').addClass('filled');
					console.log('finished');*/
					break;
				case 'prix':
				case 'M2':
				case 'ARE'://||'et'||'p'||'s'||'ja'
					//var c=APP.workers.checkRange(PAK);
					var c = APP.workers.newCheckRange(pdata,id);
					if(c.length>1){
						$('#plan-'+id+' .plan-min').val(c[0]).addClass('filled');
						$('#plan-'+id+' .plan-max').val(c[1]).addClass('filled');
						$('#plan-'+id+' span').removeClass('nodisplay');
					}else{
						$('#plan-'+id+' .plan-max').val(c[0]).addClass('filled');
					}
					break;
				case 'age':
				case 'OWNER':
				case 'AGENCE':
					$('#plan-OWNER input').val(PAK).addClass('filled');
					break;
				case 'e':
					$('#plan-e input').val(PAK).addClass('filled');
					break;
				default:
					//var c=APP.workers.checkRange(PAK);
					var c = APP.workers.newCheckRange(pdata,id);
					if(c.length>1){
						$('#plan-'+id+' .plan-min').val(c[0]).addClass('filled');
						$('#plan-'+id+' .plan-max').val(c[1]).addClass('filled');
					}else{
						$('#plan-'+id+' .plan-min').val(c[0]).addClass('filled');
					}
					break;
			}
		var animtarget;
		if($('#plan-'+id).hasClass('quadbar-spacer')){animtarget=$('#plan-'+id);}else{
			animtarget=$('#plan-'+id).parents('.quadbar-spacer');
		}
		if(src=='#APP-input'&&animtarget.length){
			var t=animtarget.position();
			var s=animtarget.width();
			var u = animtarget.attr('style');
			animtarget.css({
				"position":"absolute",
				"left":t.left,
				"top":t.top,
				"width":s
			});
			animtarget.animate({
				left:$('.'+catclass).position().left,
				top:$('.'+catclass).position().top
			},600,function(){
				animtarget.attr('style','');
				$('.'+catclass).css('visibility','visible');
				//animtarget.addClass('translu');
			});
		}else{
			//if(animtarget.length){animtarget.addClass('translu');}
			
		}
	},
	locmove: function(e){
		if(window.lastX !== e.screenX || window.lastY !== e.screenY){
        	$('#ghost').val('');
			$('.taken').removeClass('taken');
			$(this).addClass('taken');
			var that=$(this);
			APP.workers.ghostSuggest(that);
    	}// Code when the (physical) mouse actually moves
	},
	telclick:function(jayson,fromwhere,caddie){
		APP.telclicknum +=1;
		$('#initloader').remove();
		$('html').removeClass('wait');
		if(typeof(jayson.table)=="undefined"){
			alert('Error unable to load');
			return;
		}
		var header = lng('Mon Caddie','Fr')+lng('Seu Carrinho','Pt')+lng('My Cart','En');
		if(fromwhere=="telclick"){header= jayson.rows+lng(' Ads from','En')+lng(' Annonces de ','Fr')+lng(' Anúncios de','Pt')+'<div id="phonepng"> </div>  '+APP.telnum;}
		if(fromwhere=="bin"){header='Mon bin';}
		if(fromwhere=="notes"){header=lng('My notes','En')+lng('Mes Notes','Fr')+lng('Minhas Notas','Pt');}
		var download = '<div class="teldwnld" style="margin-right:10px;display: inline-block; float: right; font-weight: bold; font-size: medium; background-color: white; padding: 5px; cursor: pointer;position:relative"><span class="oi" data-glyph="file" data-toggle=".teldlmenu"></span><div class="nodisplay teldlmenu" style="position:absolute;display:inline-block;left:0px;top:26px;font-size:medium;background-color:white;border:1px solid black;padding:3px"><div class="telexcel" class="standardli" style="cursor:pointer">Excel</div><div class="telcsv" class="standardli" style="cursor:pointer">CSV</div></div></div>';
		var telprint = '<div class="telprint" style="margin-right:10px;display:inline-block; float:right; font-weight: bold; font-size: medium; background-color:white; padding: 5px; cursor: pointer;"><span class="oi" data-glyph="print"></span></div>';
		$('body').append('<div class="telwin telwin'+APP.telclicknum+'"><div class="telwin-div-one"><h1>'+header+'</h1></div><div class="telrmv" style="display: inline-block; float: right; font-weight: bold; font-size: small; background-color: white; padding: 5px; cursor: pointer;">X</div><div class="telmin" style="display: inline-block; float: right;margin-right:10px; font-weight: bold; font-size: small; background-color: white; padding: 5px 8px; cursor: pointer;">-</div>'+download+telprint+'<div class="telwin-content" style="min-height:300px;min-width:300px;background-color:white;max-height:400px;overflow-y:scroll;"><table><tbody>'+(jayson.table=="0 AD"?'<tr><td id="emptysearch"colspan="9"style="text-align:center;font-size:3em;">'+lng('Nenhum resultado encontrado','Pt')+lng('No results found','En')+lng('Aucune annonce','Fr')+'</td></tr>':jayson.table)+'</tbody></table></div></div>');
		var telwinc = $('.telwin'+APP.telclicknum);
		telwinc.find('.telexcel, .telcsv').data('cmd',caddie);
		$('<div style="text-align:center;background-color:grey;color:#fff;margin-right:3px;padding:5px; border-bottom-left-radius:3px; border-bottom-right-radius:3px;cursor:pointer;color:white;display:inline-block;font-size:small" class="telwintgl telwintgl'+APP.telclicknum+'" data-toggle=".telwin'+APP.telclicknum+'" data-togglestate="0">'+header+'</div>').insertAfter('#APP-pgnumber');
		$('.telwin table tr td[id^="tel"]').remove();
		$('.telwin table tr td .noscroll2').css({ "height":"auto", "overflow":"auto" })
		telwinc.find('[class^=textex]').remove();
		$('.telwin').draggable({
			handle: "h1",
			containment:"window"
		});
		telwinc.on('click','.telrmv',function rmvtel(){
			$('.telwin'+APP.telclicknum).remove();
			$('.telwintgl'+APP.telclicknum).remove();
		});
		$('.telwin').on('click','.telmin',function mintel(){
			$(this).parents('.telwin').addClass('nodisplay');
		});
		$('.teldwnld').mouseenter(function(){
			$('.teldlmenu').removeClass('nodisplay');
		}).mouseleave(function(){
				$('.teldlmenu').addClass('nodisplay');
			});
		$('.telwin').on('click','.telprint',function() {
			$(this).parent().find('.telwin-content').printElement({
				printmode:'popup',
				overrideElementCSS: ['5-style.css','6-style.css'],
				printBodyOptions: {
					styleToAdd:'margin-left:0px;height:auto;overflow:auto;max-height:none;min-height:none;',
					classNameToAdd:'telwin-printFrame'
				}
			});
		});
	},
	clearPlan:function(){
		$('#llastplace input').val('');
		$('#llastplace input[type="checkbox"]').prop('checked',true);
		$('#plan-biens option').prop('selected',false);
		$('#llastplace input[type="radio"]').prop('checked',false);
		$('.translu').removeClass('translu');
		$('.reserved').removeClass('reserved');
		$('.filled').removeClass('filled');
		$("#APP-recnote").text('');
		$('#APP-input').val('');
		$('.spacer').remove();
		$('.textbox').children('br').remove();
		$('#APP-clear-all').removeClass('clear-plan-filled');
		APP.oldpak='';
	},
	checkRange: function(number) {
		var o = [];
		var m = number.replace(/^[a-zA-Z]+[ ]/,'');
		var n = m.match(/([0-9]+)[-]([0-9]+)/);
		if(n){
			o = [n[1],n[2]];
		}else{
			o.push(m);
		}
		return o;
	},
	removePakVal: function(pak) {
		/*switch(pak) {
			case 'an':
			case 'MODERNE':
				$('#plan-an, #plan-mo').prop('checked',true);
				break;
			case 'MOT':
			case 'date':
			case 'pr3':
			case 'ville':
				$('#plan-'+pak).val('').data('cmd','').removeClass('filled');
				break;
			case 'OWNER':
			case 'age':
			case 'AGENCE':
				$('#plan-PART, #plan-AGENCE').prop('checked',true);
				break;
			case 'BIENS':
				$('#plan-biens option').prop('selected',false);
				break;
			default:
				$('#plan-'+pak+' input').val('').removeClass('filled');
				break;
		}*/
		APP.oldpak='';
		var id = pak.replace('APP','');
		if(id=="age"||id=="AGENCE"){
			id = "OWNER";
		}
		$('#APP-recnote').text('');
		$('#plan-'+id+' input').val('').removeClass('filled');
		if(id=="ville"){
			$('#plan-ville-textarea').val('');
		}
		if(id=="BIENS"){$('.reserved').removeClass('reserved');}
		$('#'+pak).parent('.spacer').remove();
		if($('.spacer').length<1){$('#APP-clear-all').removeClass('clear-plan-filled');}
	},
	newCheckRange: function(number, id) {
		number=htmlDecode(number);
		number = number.replace(/M2/g,'M');
		if(id=="M2"){id="M";}
		var max="[0-9]+<="+id;
		var min=id+"<=[0-9]+";
		var exact = id + "=([0-9]+)";
		var rmax = new RegExp(max,'g');
		var rmin = new RegExp(min,'g');
		var rexact = new RegExp(exact,'g');
		rmax=number.match(rmax);
		rmin=number.match(rmin);
		rexact=number.match(exact);
		var o = [];
		if(rmax&&rmin){
			o=[rmax[0].replace(/[^0-9]*/g,''),rmin[0].replace(/[^0-9]*/g,'')];
		}else{
			if(rmin){
				o.push(rmin[0].replace(/[^0-9]*/g,''));
			}
			if(rmax){
				o.push(rmax[0].replace(/[^0-9]*/g,''));
			}
			if(rexact){
				o=[rexact[1],rexact[1]];
			}
		}
		return o;
	},
	validateKey: function(e) {
		var ex = [40,37,38,39,9,32,16,18,19,20,27,33,34,35,36,45,46,91,92,93]
		for(i=0;i<ex.length;i++){
			if(e==ex[i]||(e>111&&e<186)){
				return false;
			}
		}
		return true;
	},
	handlebar: function() {
		if($('#APP-handlebar').hasClass('APP-toggled')){
				$('#dynputdiv').animate({
					"left":"0"
				},500);
				$('#APP-handlebar').removeClass('APP-toggled');
			}else{
				$('#dynputdiv').animate({
					"left":"-1025px"
				},500);
				$('#APP-handlebar').addClass('APP-toggled');
			}
	},
	generateHistory: function(data,where) {
		var temparray = [];
		var dest='.historymenu';
		if(where==1){dest='.dbghistorymenu'}
		for(item in data) {
			temparray.push([item,data[item]]);
		}
		temparray.sort(function(a,b){return a[1].Tim - b[1].Tim});
		temparray.reverse();
		for(i=0;i<temparray.length;i++) {
			var histitem='<li class="historyitem" style="color:#FFFFFF;">' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[0] + ' ' + (temparray[i][1].TimStr?('&nbsp;<small>Server time: '+temparray[i][1].TimStr+'</small>'):'') + APP.workers.sortPAK(temparray[i][1].PakCmd) + (temparray[i][1].Em?('<span class="bdgry">'+temparray[i][1].Em+(temparray[i][1].Ph?(' <strong>Tel: '+temparray[i][1].Ph+'</strong>'):'')+(temparray[i][1].Id?('&nbsp;<small>id: '+temparray[i][1].Id+'</small>'):'')+'</span>'):"") + '</li>';
			if($('.' +(where==1?'dbg-':'')+ APP.workers.timeConverter(Number(temparray[i][1].Tim))[2]).length) {
				$('.' +(where==1?'dbg-':'')+ APP.workers.timeConverter(Number(temparray[i][1].Tim))[2]).append(histitem);
			}else {
				$(dest).append('<ul style="list-style:none;margin:0;padding-left:0;"class="'+(where==1?'dbg-':'') + APP.workers.timeConverter(Number(temparray[i][1].Tim))[2] + '"><li style="text-align:center;cursor:pointer;margin:3px;border:1px solid #898989;"><span class="carettoggle">&#9660;</span>  ' + APP.workers.timeConverter(Number(temparray[i][1].Tim))[1] + '</li>'+histitem+'</ul>');
			}
		}
		$('.historyitem').on('click','.bdgry',function(event) {
			event.stopPropagation();
		});
	},
	clickHistory: function(that,where) {
		APP.workers.clearPlan();
		var b = that.children('.bookmark-desc').children('.historyUniquecmd');
		b.each(function() {
			var v = '';
			var thistext= $(this).children('.historyPakR').html();
			if($(this).children('.historycmdn').len){
				v = $(this).children('.historycmdn').text();
			}else{
				if($(this).children('.historyPakL').text().match('index')){
					v = 'INDEX'
				}else{
					for(i=0;i<APP.cmdpossibilities.length;i++) {
						if(escapeRegExp($(this).children('.historyCmd').text()).match(APP.cmdpossibilities[i].cmd)) {
							v = APP.cmdpossibilities[i].cmdname;
						}
						if($(this).children('.historyCmd') == "1") {
							v = 'OWNER';
						}
					}
				}
			}
			APP.workers.insertSpacer(v,$(this).children('.historyCmd').html(),$(this).children('.historyPakL').html(),thistext.replace(/^[ ]+/,''),((typeof($(this).children('.historycat'))=='object')&&(Chk=$(this).children('.historycat'))?Chk.html().replace(/,.*$/,''):''));
						//,((Chk=$(this).children('.historycat'))&&typeof(Chk)=='object')?Chk.html():''
							//,$(this).data('cat')
		});
		if(where=="top"){
			var uInfo = that.children('.bdgry').html();
			$('#search-userinfo div:first-child').html('');
			$('#search-userinfo div:first-child').append(that.siblings('li:first-child').text()+': ');
			$('#search-userinfo div:first-child').append(uInfo);
			if(!$('.rmvsuinfo').len){$('#search-userinfo div:first-child').append('<div class="rmvsuinfo" style="float:right;background-color:grey;padding:3px;display:inline-block;cursor:pointer;color:white;">x</div>');}
			$('.rmvsuinfo').click(function rmvsuinfo(){
				$('#search-userinfo div:first-child').html('');
				$(this).remove();
			});
		}
		$('.historymenu').scrollTop(0);
		$('#historymenu').addClass('nodisplay');
		//setTimeout("APP.workers.respace();",10);
		APP.workers.respace();
	},
	prevscroll: function(){$(window).scrollTop(APP.wpos);}
};
function escapeRegExp(string){
  return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}
function htmlEncode(value){
  //create a in-memory div, set it's inner text(which jQuery automatically encodes)
  //then grab the encoded contents back out.  The div never exists on the page.
  return $('<div/>').text(value).html();
}
function htmlDecode(value){
  return $('<div/>').html(value).text();
}
function setBkmrk(statusval){
$.ajax({
	method: "GET",
	url: '/?&lg=&z=0&gotck=1&EQ=0&MAC=0&inframe=1&order=&where=' + APP.workers.getOutput()[0] + '&PAGE=' + APP.currentpage + '&rechsav=1&frec=' + $('#bookmarknameinput').val() + '&recec=0&recnote=' + APP.workers.getNewOutput() + '&falerte=' + statusval
}).done(function() {
	$('#newbookmarksmenu').addClass('nodisplay');
	$('.APP-menubaroptionsspan').removeClass('toggled');
	/*var pakreplace = APP.workers.getOutput()[1].replace(/[ ]+AND[ ]+?/, ', ');
	var checkemail = function( jquer ) {
		var pel = '';
		if(jquer.prop('checked',true)) {
			pel = '<span class="oi" data-glyph="envelope-closed" aria-hidden="true" title="remove email alert">';
		}
		return pel;
	};
	$('#afterviewbookmarks ul').prepend('<li class="standardli" title="' + pakreplace + '">' + $('#bookmarknameinput').val() + '<span style="position:relative;float:right;top:-13px;"><span style="margin-right:3px;"class="oi" data-glyph="circle-x" aria-hidden="true" class="" title="Delete bookmark"></span><span>' + checkemail($('#emailalerttoggle')) + '</span></span><span class="alertlistcmd nodisplay">' + APP.openURL + '</span><span class="alertlistPAK nodisplay">' + pakreplace + '</span></li>');*/
	//APP.ticketJSON1();
	APP.workers.checkBookmarks();
});
}
$(document).ready(function(){
APP.init();
});