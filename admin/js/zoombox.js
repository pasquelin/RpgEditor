/* ------------------------------------------------------------------------
	Class: zoombox
	Auteur: Jonathan Boyer (http://www.grafikart.fr)
	Version: 1.0.1
	
	- Historique de Modifications: 
		# BARRY Thierno IB. (ibrahima.br@gmail.com): Lundi 22/12/2008
			+ Prise en charge de la navigation par les touches directionnelles
			+ Sortie de la zoombox avec ESC
------------------------------------------------------------------------- */

$(document).ready(function(){
		zoombox.init();
});
zoombox = {
		// Configure la boite
		/////////////////
		init : function(){
				zoombox.largeurD=580; // Largeur par d�faut 
				zoombox.hauteurD=526; // Hauteur par d�faut
				zoombox.duree=750;	// Dur�e des animation en ms
				zoombox.fond="#000000";
				zoombox.lecteurFLV="images/zoombox/FLVplayer.swf" // Ou se trouve le lecteur FLV par rapport � la racine
				zoombox.lecteurMP3="images/zoombox/mp3player.swf" // Ou se trouve le lecteur MP3 par rapport � la racine
				// Trouve toutes les images
				zoombox.images = new Array();
				galleryRegExp = /\[(?:.*)\]/
				$("a[rel^='zoombox']").each(function(){
						if(!zoombox.images[galleryRegExp.exec($(this).attr("rel"))]){
								zoombox.images[galleryRegExp.exec($(this).attr("rel"))]=new Array();
						}
						zoombox.images[galleryRegExp.exec($(this).attr("rel"))].push($(this));
						$(this).bind('click',function(){
								zoombox.gallerie=galleryRegExp.exec($(this).attr("rel"));
								zoombox.attr_class=$(this).attr("class");
								zoombox.div=$(this);
								zoombox.top=$(this).offset().top-18;
								zoombox.left=$(this).offset().left-18;
								zoombox.largeur=$(this).width();
								zoombox.hauteur=$(this).height();
								if($(this).children("img").length){
										zoombox.hauteur=$(this).children("img").height();
										zoombox.top=$(this).children("img").offset().top-18;
								}
								zoombox.open();
								return false;
						});
				});
				$(window).resize(function(){
						zoombox.recadrer();
				});
		},
		// Cr�ation des divs
		///////////////
		open : function(){
				for (i = 0; i < zoombox.images[zoombox.gallerie].length; i++){
						if($(zoombox.images[zoombox.gallerie][i]).attr("href") == zoombox.div.attr("href")){
								zoombox.position=i;
						}
				}
				$("embed").css("visibility","hidden"); // On cache tous les �l�ments qui pourrait pass� par dessus zoombox
				$("object").css("visibility","hidden");
			
				$('body').append("<div id='zoombox'></div>");
			
				zoombox.aplat();
			
				$('#zoombox').append("<div id='zoombox_conteneur'></div>");

				$('#zoombox_conteneur').append("<div id='zoombox_conteneur2'></div>");		
			
				$('#zoombox_conteneur2').append("<div id='zoombox_close'></div>");
			
				$('#zoombox_conteneur2').append("<div id='zoombox_titre'></div>");			
				$('#zoombox_titre').append('<table cellspacing="0" cellpadding="0" border="0" style="margin:0 auto;"><tr><td id="zoombox_titreg"></td><td id="zoombox_titrec"></td><td id="zoombox_titred"></td></tr></table>')
			
				if(zoombox.gallerie){
						$('#zoombox_titre table tr').append('<td width="39"><a id="zoombox_boutond"></a></td>');
						$('#zoombox_titre table tr').prepend('<td width="39"><a id="zoombox_boutong"></a></td>');
						$("#zoombox_boutond").click(function(){
								zoombox.next()
								});
						$("#zoombox_boutong").click(function(){
								zoombox.prev()
								});
						///////////////////////modification Ibrahima///////////////////////
						//On passe a l'image suivante si on appuie sur Rigth = 39 en ASCII
						//On passe a l'image pr�c�dente si on appuie sur Left = 37 en ASCII
						$(document).keyup(function(event){
								//Avec ce filtre tu pouras bien t'amuser avec le clavier... il suffit d'imaginer
								//alert(event.keyCode);
								if(event.keyCode==39){
										zoombox.next();
								}
								else if(event.keyCode==37){
										zoombox.prev()
								}
						});


						if(zoombox.position==zoombox.images[zoombox.gallerie].length-1){
								$("#zoombox_boutond").hide();
						}
						if(zoombox.position==0){
								$("#zoombox_boutong").hide();
						}
				}
			
				$('#zoombox_conteneur2').append("<div id='zoombox_bg'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_h'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_b'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_d'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_g'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_bg'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_bd'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_hg'></div>");
				$('#zoombox_bg').append("<div class='zoombox_bg_hd'></div>");
			
				$('#zoombox_conteneur2').append("<div id='zoombox_contenu'></div>");
				$('#zoombox_contenu').css({
						'background-color': zoombox.fond
						});
			
				$('#zoombox_contenu').hide();
				$('#zoombox_conteneur2').hide();
			
				$('#zoombox_conteneur').css({
						'top':zoombox.top+"px"
						});
				$('#zoombox_conteneur').css({
						'left':zoombox.left+"px"
						});
				$('#zoombox_conteneur').css({
						'width':zoombox.largeur+"px"
						});
				$('#zoombox_conteneur').css({
						'height':zoombox.hauteur+"px"
						});
				zoombox.setContent();
			
				$("#zoombox_close").click(function(){
						zoombox.close();
				})
				///////////////////////modification Ibrahima///////////////////////
				//On sort de la zoombox si on appuie sur ESC = 27 en ASCII
				$(document).keyup(function(event){
						if(event.keyCode==27)
								zoombox.close();
				});
				$("#zoombox_aplat").click(function(){
						zoombox.close();
				})
		
		},
		// Fermeture de zoombox
		///////////////
		close : function(){
				div=zoombox.div;
				zoombox.top=div.offset().top-18;
				zoombox.left=div.offset().left-18;
				zoombox.largeur=div.width();
				zoombox.hauteur=div.height();
				$('#zoombox_bg').hide();
				//$('#zoombox_close').fadeOut(zoombox.duree); // plante sur IE7 et Google Chrome
				if(div.children("img").length){
						zoombox.hauteur=div.children("img").height();
						zoombox.top=div.children("img").offset().top-18;
				}
				$('#zoombox_aplat').fadeOut(250);
				$('#zoombox_titre').animate({
						opacity: 0
				},zoombox.duree);
				if(zoombox.type!="img"){
						$('#zoombox_contenu').empty();
				}
				$('#zoombox_contenu').animate({
						opacity: 0
				},zoombox.duree);
				$('#zoombox_conteneur').animate({
						width: zoombox.largeur+"px",
						height: zoombox.hauteur+"px",
						left: zoombox.left+"px",
						top: zoombox.top+"px"
				},zoombox.duree,function(){
						$("embed").css("visibility","visible"); // On cache tous les �l�ments qui pourrait pass� par dessus zoombox
						$("object").css("visibility","visible");
						$("#zoombox").remove();
				});
		
		},
		// Redimensionnement
		///////////////
		redim : function(){
				if($("#zoombox_conteneur2").is(":hidden") && zoombox.type=="img"){
						$('#zoombox_contenu').append(zoombox.contenu);
				}
				if($('#zoombox_contenu').is(":hidden")){
						$('#zoombox_contenu').fadeIn();
						$('#zoombox_conteneur2').show();
				}
				$("#zoombox_titrec").empty();
				$("#zoombox_titrec").append(zoombox.titre);
				zoombox.left=($(window).width()-zoombox.largeur-36)/2;
				zoombox.top=((zoombox.windowH()-zoombox.hauteur-36)/2)+zoombox.scrollY();	
				$('#zoombox_conteneur').animate({
						width: zoombox.largeur+"px",
						height: zoombox.hauteur+"px",
						left: zoombox.left+"px",
						top: zoombox.top+"px"
				},zoombox.duree,function(){
						// LE redim est termin�
						if($('#zoombox_contenu').is(":empty") || zoombox.type!="img"){
								$('#zoombox_contenu').append(zoombox.contenu);
								if(zoombox.type=="img"){
										$("#zoombox_contenu img").hide();
										$("#zoombox_contenu img").fadeIn();
								}
								else{
										$("zoombox_contenu").show();
								}
						}
						if(($("#zoombox_titre").is(":hidden") && zoombox.gallerie) || (!zoombox.gallerie && $("#zoombox_titre").is(":hidden") && zoombox.titre)){
								$("#zoombox_titre").fadeIn(zoombox.duree);
						}

				});
		
		},
		recadrer : function(){
				if((zoombox.hauteur+120)>zoombox.windowH() && zoombox.type=="img"){
						zoombox.largeur=zoombox.largeur*((zoombox.windowH()-120)/zoombox.hauteur);
						zoombox.hauteur=(zoombox.windowH()-120);
				}
				zoombox.left=($(window).width()-zoombox.largeur-36)/2;
				zoombox.top=((zoombox.windowH()-zoombox.hauteur-36)/2)+zoombox.scrollY();	
				$('#zoombox_conteneur').css("width",zoombox.largeur+"px");
				$('#zoombox_conteneur').css("height",zoombox.hauteur+"px");
				$('#zoombox_conteneur').css("left",zoombox.left+"px");
				$('#zoombox_conteneur').css("top",zoombox.top+"px");
		},
		setContent : function(){
				zoombox.titre=zoombox.div.attr("title");
				zoombox.lien=zoombox.div.attr("href");
				taille=zoombox.div.attr("rel").split(' ');
				if((taille[1])&&(taille[2])){
						zoombox.largeur = parseInt(taille[1]);
						zoombox.hauteur =  parseInt(taille[2]);
				}
				else{
						zoombox.largeur=zoombox.largeurD;
						zoombox.hauteur=zoombox.hauteurD;
				}
				// mmh des expression r�guli�re 
				// On v�rifie le zoombox.lien pour g�n�rer le code en fonction
				filtreImg=/(\.jpg)|(\.jpeg)|(\.bmp)|(\.gif)|(\.png)/i
				filtreMP3=/(\.mp3)/i
				filtreFLV=/(\.flv)/i
				filtreSWF=/(\.swf)/i
				filtreQuicktime=/(\.mov)|(\.mp4)/i
				filtreWMV=/(\.wmv)/i
				filtreDailymotion=/(http:\/\/www.dailymotion)|(http:\/\/dailymotion)/i
				filtreVimeo=/(http:\/\/www.vimeo)|(http:\/\/vimeo)/i
				filtreYoutube=/(youtube\.)/i
				filtreKoreus=/(http:\/\/www\.koreus)|(http:\/\/koreus)/i
				filtreDeezer=/(http:\/\/www\.deezer)|(http:\/\/deezer)/i
				zoombox.type="multi";
				// On �vite les tailles trop grandes
				if((zoombox.hauteur+120)>zoombox.windowH()){
						zoombox.largeur=zoombox.largeur*((zoombox.windowH()-120)/zoombox.hauteur);
						zoombox.hauteur=(zoombox.windowH()-120);
				}
				if(filtreImg.test(zoombox.lien)){
						img=new Image();
						img.src=zoombox.lien;	
						$('#zoombox').append("<div id='zoombox_loading'></div>");
						zoombox.timer = window.setInterval("zoombox.charger(img)",100);
						zoombox.type="img";
						return true;
				}
				else if(filtreMP3.test(zoombox.lien)){
						zoombox.largeur=300;
						zoombox.hauteur=40;
						zoombox.contenu='<object type="application/x-shockwave-flash" data="'+zoombox.lecteurMP3+'?son='+zoombox.lien+'" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'">';
						zoombox.contenu+='<param name="movie" value="'+zoombox.lecteurMP3+'?son='+zoombox.lien+'" /></object>';
				}		
			
				else if(filtreFLV.test(zoombox.lien)){
						zoombox.contenu='<embed src="'+zoombox.lecteurFLV+'" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" allowscriptaccess="always" allowfullscreen="true" flashvars="file='+zoombox.lien+'&width='+zoombox.largeur+'&height='+zoombox.hauteur+'" wmode="transparent" />';			
				}
			
				else if(filtreSWF.test(zoombox.lien)){
						zoombox.contenu='<object width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="'+zoombox.lien+'" /><embed src="'+zoombox.lien+'" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" wmode="transparent"></embed></object>';		
				}
			
				else if(filtreQuicktime.test(zoombox.lien)){
						zoombox.contenu='<embed src="'+zoombox.lien+'" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" controller="true" cache="true" autoplay="true"/>';
				}
			
				else if(filtreWMV.test(zoombox.lien)){
						zoombox.contenu='<embed src="'+zoombox.lien+'" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" controller="true" cache="true" autoplay="true" wmode="transparent" />';
				}

				else if(filtreDailymotion.test(zoombox.lien)){
						id=zoombox.lien.split('_');
						id=id[0].split('/');
						id=id[id.length-1];
						zoombox.contenu='<object width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"><param name="movie" value="http://www.dailymotion.com/swf/'+id+'&colors=background:000000;glow:000000;foreground:FFFFFF;special:000000;&related=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed src="http://www.dailymotion.com/swf/'+id+'&colors=background:000000;glow:000000;foreground:FFFFFF;special:000000;&related=0" type="application/x-shockwave-flash" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" allowFullScreen="true" allowScriptAccess="always" wmode="transparent" ></embed></object>';
				}
			
			
				else if(filtreVimeo.test(zoombox.lien)){
						id=zoombox.lien.split('/');
						id=id[3];
						zoombox.contenu='<object width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"><param name="allowfullscreen" value="true" />	<param name="allowscriptaccess" value="always" />	<param name="movie" value="http://www.vimeo.com/moogaloop.swf?clip_id='+id+'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00AAEB&amp;fullscreen=1" />	<embed src="http://www.vimeo.com/moogaloop.swf?clip_id='+id+'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00AAEB&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" wmode="transparent" ></embed></object>';
				}
			
			
				else if(filtreYoutube.test(zoombox.lien)){
						id=zoombox.lien.split('watch?v=');
						id=id[1].split('&');
						id=id[0];
						zoombox.contenu='<object width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"><param name="movie" value="http://www.youtube.com/v/'+id+'&hl=fr&rel=0&color1=0xFFFFFF&color2=0xFFFFFF"></param><embed src="http://www.youtube.com/v/'+id+'&hl=fr&rel=0&color1=0xFFFFFF&color2=0xFFFFFF" type="application/x-shockwave-flash" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'" wmode="transparent"></embed></object>';
				}
			
			
				else if(filtreKoreus.test(zoombox.lien)){
						zoombox.lien=zoombox.lien.split('.html');
						zoombox.lien=zoombox.lien[0];
						zoombox.contenu='<object type="application/x-shockwave-flash" data="'+zoombox.lien+'" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"><param name="movie" value="'+zoombox.lien+'"><embed src="'+zoombox.lien+'" type="application/x-shockwave-flash" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"  wmode="transparent"></embed></object>';
				}
			
			
				else if(filtreDeezer.test(zoombox.lien)){
						zoombox.largeur=220;
						zoombox.hauteur=55;
						id=zoombox.lien.split('/');
						id=id[id.length-1];
						zoombox.contenu='<object width="220" height="55"><param name="movie" value="http://www.deezer.com/embedded/small-widget-v2.swf?idSong='+id+'&colorBackground=0x000000&textColor1=0xFFFFFF&colorVolume=0xFF6600&autoplay=0"></param><embed src="http://www.deezer.com/embedded/small-widget-v2.swf?idSong='+id+'&colorBackground=0x000000&textColor1=0xFFFFFF&colorVolume=0xFF6600&autoplay=0" type="application/x-shockwave-flash" width="220" height="55" wmode="transparent"></embed></object>';
				}
			
				else{
						zoombox.contenu='<iframe src="'+zoombox.lien+'" width="'+zoombox.largeur+'" height="'+zoombox.hauteur+'"></iframe>';
						if( zoombox.attr_class != 'no_sous_lien' )
						{
								zoombox.titre=zoombox.titre+' (<a href="'+(zoombox.lien)+'?template=1" target="_blank">Ouvrir dans une nouvelle page</a>)';
								$("#zoombox_titrec").append(' (<a href="'+(zoombox.lien)+'?template=1" target="_blank">Ouvrir dans une nouvelle page</a>)');
						}
				}	
				$("#zoombox_contenu").empty();
				zoombox.redim();
		},
		next : function(){
				///////////////////////modification Ibrahima///////////////////////
				//On passe a l'image suivante que si nous n'avons pas atteint la limite
				//sup�rieure d'images dans le tableaux.
				if(zoombox.position<zoombox.images[zoombox.gallerie].length-1){
						zoombox.position++;
						zoombox.div=zoombox.images[zoombox.gallerie][zoombox.position];
						zoombox.setContent();	
				}
				if(zoombox.position==zoombox.images[zoombox.gallerie].length-1){
						$("#zoombox_boutond").fadeOut();
				}
				if($("#zoombox_boutong").is(":hidden")){
						$("#zoombox_boutong").fadeIn();
				}
		},
		prev : function(){
				///////////////////////modification Ibrahima///////////////////////
				//On passe a l'image pr�c�dente que si nous n'avons pas atteint la 
				//limite inf�rieure d'images dans le tableaux.
				if(zoombox.position>0){
						zoombox.position--;
						zoombox.div=zoombox.images[zoombox.gallerie][zoombox.position];
						zoombox.setContent();
				}
				if(zoombox.position==0){
						$("#zoombox_boutong").fadeOut();
				}
				if($("#zoombox_boutond").is(":hidden")){
						$("#zoombox_boutond").fadeIn();
				}
		},
		// Aparition de l'aplat
		///////////////
		aplat : function(){
			
				$('#zoombox').append("<div id='zoombox_aplat'></div>");
				$('#zoombox_aplat').css({
						'opacity': 0
				});
				$('#zoombox_aplat').fadeTo(250,0.4);
			
		},
		// Chargement d'une image
		///////////////	
		charger : function(img){
				if(img.complete){
						$("#zoombox_conteneur").show();
						window.clearInterval(zoombox.timer);
						zoombox.largeur=img.width;
						zoombox.hauteur=img.height;
						zoombox.contenu='<img src="'+img.src+'" width="100%" height="100%"/>';
						$('#zoombox_loading').remove();
						// On �vite les tailles trop grandes
						if((zoombox.hauteur+120)>zoombox.windowH()){
								zoombox.largeur=zoombox.largeur*((zoombox.windowH()-120)/zoombox.hauteur);
								zoombox.hauteur=(zoombox.windowH()-120);
						}
						if($('#zoombox_contenu img').length){
								$('#zoombox_contenu img').fadeOut(500,function(){
										$('#zoombox_contenu').empty();
										zoombox.redim();
								})
						}
						else{
								$('#zoombox_contenu').empty();
								zoombox.redim();
						}
				}	
				// On anim le loader
				if(typeof(j)=='undefined'){
						j=0;
				}
				$('#zoombox_loading').css({
						'background-position': "0px "+j+"px"
						});
				j=j-40;
				if(j<(-440)){
						j=0;
				}
		},
		scrollY : function() {
				scrOfY = 0;
				if( typeof( window.pageYOffset ) == 'number' ) {
						//Netscape compliant
						scrOfY = window.pageYOffset;
				} else if( document.body && ( document.body.scrollTop ) ) {
						//DOM compliant
						scrOfY = document.body.scrollTop;
				} else if( document.documentElement && ( document.documentElement.scrollTop ) ) {
						//IE6 standards compliant mode
						scrOfY = document.documentElement.scrollTop;
				}
				return scrOfY;
				alert(scrOfY);
		},
		windowH : function(){
				if (window.innerHeight) return window.innerHeight  ;
				else{
						return $(window).height();
				}
		}
}
