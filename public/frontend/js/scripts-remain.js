function gtag(){dataLayer.push(arguments)}$(window).on("load",function(){$("body").delay(550).css({overflow:"visible"}),$(".hero_img").show(),$(".hero_img").slick({slidesToShow:1,infinite:!0,slidesToScroll:1,autoplay:!0,pauseOnFocus:!1,pauseOnHover:!1,fade:!0,arrows:!1,speed:5e3})}),$(document).on("click",".menu_toggle",function(){$("body").toggleClass("menu_open")}),$(document).bind("click",function(a){$(a.target).hasClass("menu_toggle")||$("body").removeClass("menu_open")}),$(document).on("click","#loadMore",function(){$(".loader-img").show();let a=$(this).attr("data-href");$.ajax({url:a,cache:!1,beforeSend:function(){$(".not-loading").show(),$("#loadMore").hide()},success:function(a){let i="",e="",t=JSON.parse(a),o=$(".project-list-view").last().find("a").attr("data-slide");for(var s=0;s<t.data.length;s++){let l=t.data[s],d=l.title.toString().toUpperCase();var n=l.description;if(0==l.fullwidth_image)popupHtmlSlide='<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="project_box"><img src="'+l.main_image+'" alt="'+l.title+'"><div class="project_info"><h2>'+d+"</h2><p>"+n+'</p><div class="material_ids">'+l.hash_tags+"</div></div></div></div></div></div>";else{for(j=0,popupHtmlSlide='<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="project_box full-width-class"><div id="big_puma'+l.id+'" class="carousel slide carousel-fade" data-bs-ride="carousel"><div class="carousel-inner"><div class="carousel-item active"><img src="'+l.main_image+'" alt="'+l.title+'"></div>';j<l.media.length;j++)popupHtmlSlide+='<div class="carousel-item"><img src="'+l.media[j].image+'" alt="'+l.media[j].image+'"></div>';for(popupHtmlSlide+='</div><div class="my slider carousel-indicators" style="margin-bottom: ;"><div class="op position-relative"><button type="button" data-bs-target="#big_puma'+l.id+'" data-bs-slide-to="0" class="active" aria-label="Slide 1" tabindex="0"><img src="'+l.main_image+'" alt="'+l.title+'"></button>',j=0;j<l.media.length;j++){let c=j+1,r=j+2;popupHtmlSlide+='<button type="button" data-bs-target="#big_puma'+l.id+'" data-bs-slide-to="'+c+'" aria-label="Slide '+r+'" class="" tabindex="0"><img src="'+l.media[j].image+'" alt="'+l.media[j].image+'"></button>'}popupHtmlSlide+='</div></div></div><div class="project_info"><h2>'+d+"</h2><p>"+n+'</p><div class="material_ids">'+l.hash_tags+"</div></div></div></div></div></div>"}e+=popupHtmlSlide,i+='<div class="project_box project-list-view"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#puma_detail" data-slide='+ ++o+'><div class="project_image_outer"><img src="'+l.thumbnail+'" alt="'+l.title+'"></div><div class="project_info"><h2>'+d+"</h2><p>"+n+'</p></div><div class="material_ids d-sm-none">'+l.hash_tags+"</div></a></div>"}$(".modal_slider").hasClass("slick-initialized")&&$(".modal_slider").slick("unslick"),$(".modal-dialog").last().after(e),t.current_page==t.last_page?$("#loadMore").hide():$("#loadMore").attr("data-href",t.next_page_url).show(),$(".not-loading").hide(),$(".project-list-view").last().after(i)}})}),equalheight=function(a){var i,e=0,t=0,o=[];$(a).each(function(){if(i=$(this),$(i).height("auto"),t!=(topPostion=i.position().top)){for(currentDiv=0;currentDiv<o.length;currentDiv++)o[currentDiv].height(e);o.length=0,t=topPostion,e=i.height(),o.push(i)}else o.push(i),e=e<i.height()?i.height():e;for(currentDiv=0;currentDiv<o.length;currentDiv++)o[currentDiv].height(e)})},$(window).on("load",function(){equalheight(".project_content p")}),$(window).resize(function(){equalheight(".project_content p")}),$(window).on("load",function(){equalheight(".blog_content a h2")}),$(window).resize(function(){equalheight(".blog_content a h2")}),$(document).on("click",".accept-cokkie",function(){document.cookie="acceptCookies=1",$(".cookies_bar").hide()}),$(document).on("click",".cookie-btn",function(){$(".cookies_bar").hide()}),$(".hero_img").on("beforeChange",function(a,i,e){$(".hero_img").addClass("works"),setTimeout(function(){$(".hero_img").removeClass("works")},1500)}),$(document).ready(function(){}),$("#formValidation").submit(function(a){a.preventDefault();var i=$("input[name=_token]").val(),e=$("input[name=name]").val(),t=$("input[name=email]").val(),o=$("input[name=mobile]").val(),s=$("textarea[name=message]").val(),l=this.action;if(""==$("#g-recaptcha-response").val())return alert("Captcha Error!!"),!1;$.ajax({type:"POST",url:l,dataType:"json",data:{_token:i,name:e,email:t,mobile:o,message:s},success:function(a){a.success&&($("#alert").html(a.success).fadeIn(2e3).fadeOut(4e3),document.getElementById("formValidation").reset())}})}),window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","UA-252419676-1");