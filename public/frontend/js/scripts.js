function gtag(){dataLayer.push(arguments)}$(window).scroll(function(){$(this).scrollTop()>153?$("header").addClass("sticky_top"):$("header").removeClass("sticky_top"),$(this).scrollTop()>700?$("header").addClass("sticky"):$("header").removeClass("sticky"),$(this).scrollTop()>160?$(".project_page header").addClass("inner_sticky"):$(".project_page header").removeClass("inner_sticky")}),$(document).on("click",".project-list-thumbnail",function(){let e=$(this).attr("data-slide");$(".modal-dialog").find(".project_box").find("img").hide(),$(".modal-dialog").find(".project_info").hide(),$(".modal-dialog").find(".project_box").addClass("hide_content"),$(".modal-dialog").find(".carousel").hide(),setTimeout(function(){$(".modal_slider").not(".slick-initialized").slick({slidesToScroll:1,slidesToShow:1,arrows:!0,dots:!1,speed:1e3}),$(".modal_slider").slick("slickGoTo",e,!0),$(".modal-dialog").find(".project_box").find("img").show(),$(".modal-dialog").find(".project_box").removeClass("hide_content"),$(".modal-dialog").find(".project_info").show(),$(".modal-dialog").find(".carousel").show()},700)}),$(document).ready(function(){525>$(window).width()&&($(".our_team_content.team_box").remove(),setTimeout(function(){$(".team_members").slick({slidesToShow:1,slidesToScroll:1,speed:800,infinite:!0})},100)),525>$(window).width()&&($(".team_members").slick({infinite:!0,slidesToShow:1,slidesToScroll:1,speed:1200}),$(".blog_thubnails").slick({infinite:!1,slidesToShow:1,slidesToScroll:1,speed:1200})),$(".heading_carousal").slick({slidesToScroll:2,slidesToShow:2,arrows:!1,dots:!1,speed:2e3,autoplay:!0,cssEase:"linear",autoplaySpeed:2e3,vertical:!0,verticalSwiping:!0}),$(".trusted_slider").slick({infinite:!0,slidesToShow:10,slidesToScroll:1,arrows:!0,pauseOnHover:!1,pauseOnFocus:!1,speed:6e3,autoplay:!0,autoplaySpeed:0,cssEase:"linear",responsive:[{breakpoint:1023,settings:{slidesToShow:4,slidesToScroll:1,arrows:!1}},{breakpoint:600,settings:{slidesToShow:3,slidesToScroll:1}},]}),$(".projects_slider").slick({infinite:!1,slidesToShow:1,slidesToScroll:1,speed:1200}),$(".projects__mobile_slider").slick({infinite:!0,slidesToShow:1,slidesToScroll:1,speed:1200}),$(".project_second_section").slick({infinite:!1,slidesToShow:1,slidesToScroll:1,speed:1200}),$(".project_third_section").slick({infinite:!1,slidesToShow:1,slidesToScroll:1,speed:1200}),$.ajax({url:SITE_URL+"virtualTours",cache:!1,success:function(e){$(".virtual_tours_imgs").find("div").html(e)},complete:function(){$(".virtual_tours_slider").slick({infinite:!1,slidesToShow:4,slidesToScroll:1,speed:1200,responsive:[{breakpoint:1023,settings:{slidesToShow:3,slidesToScroll:1}},{breakpoint:600,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:525,settings:{slidesToShow:1,slidesToScroll:1}},]})}}),$("#formValidation").validate({rules:{name:{required:!0},email:{required:!0,email:!0},mobile:{required:!0,digits:!0},message:{required:!0},captcha:{required:!0}},errorElement:"span",errorPlacement:function(e,i){e.addClass("invalid-feedback"),i.closest(".form-group").append(e)},highlight:function(e,i,a){$(e).addClass("is-invalid")},unhighlight:function(e,i,a){$(e).removeClass("is-invalid")}})}),$(window).on("load",function(){$("body").delay(550).css({overflow:"visible"}),$(".hero_img").show(),$(".hero_img").slick({slidesToShow:1,infinite:!0,slidesToScroll:1,autoplay:!0,pauseOnFocus:!1,pauseOnHover:!1,fade:!0,arrows:!1,autoplaySpeed:7e3})}),$(document).on("click",".menu_toggle",function(){$("body").toggleClass("menu_open")}),$(document).bind("click",function(e){$(e.target).hasClass("menu_toggle")||$("body").removeClass("menu_open")}),$(document).on("click","#loadMore",function(){$(".loader-img").show();let e=$(this).attr("data-href");$.ajax({url:e,cache:!1,beforeSend:function(){$(".not-loading").show(),$("#loadMore").hide()},success:function(e){let i="",a="",s=JSON.parse(e),o=$(".project-list-view").last().find(".project-list-thumbnail").attr("data-slide");for(var t=0;t<s.data.length;t++){let l=s.data[t],d=l.title.toString().toUpperCase();var n=l.description;if(0==l.fullwidth_image)popupHtmlSlide='<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="project_box"><img src="'+l.main_image+'" alt="'+l.title+'"><div class="project_info"><h2>'+d+"</h2><p>"+n+'</p><div class="material_ids">'+l.hash_tags+"</div></div></div></div></div></div>";else{for(j=0,popupHtmlSlide='<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="project_box full-width-class"><div id="big_puma'+l.id+'" class="carousel slide carousel-fade" data-bs-ride="carousel"><div class="carousel-inner"><div class="carousel-item active"><img src="'+l.main_image+'" alt="'+l.title+'"></div>';j<l.media.length;j++)popupHtmlSlide+='<div class="carousel-item"><img src="'+l.media[j].image+'" alt="'+l.media[j].image+'"></div>';for(popupHtmlSlide+='</div><div class="my slider carousel-indicators" style="margin-bottom: ;"><div class="op position-relative"><button type="button" data-bs-target="#big_puma'+l.id+'" data-bs-slide-to="0" class="active" aria-label="Slide 1" tabindex="0"><img src="'+l.main_image+'" alt="'+l.title+'"></button>',j=0;j<l.media.length;j++){let c=j+1,r=j+2;popupHtmlSlide+='<button type="button" data-bs-target="#big_puma'+l.id+'" data-bs-slide-to="'+c+'" aria-label="Slide '+r+'" class="" tabindex="0"><img src="'+l.media[j].image+'" alt="'+l.media[j].image+'"></button>'}popupHtmlSlide+='</div></div></div><div class="project_info"><h2>'+d+"</h2><p>"+n+'</p><div class="material_ids">'+l.hash_tags+"</div></div></div></div></div></div>"}a+=popupHtmlSlide,i+='<div class="project_box project-list-view"><div data-bs-toggle="modal" data-bs-target="#puma_detail" data-slide='+ ++o+' class="project-list-thumbnail"><div class="project_image_outer"><img src="'+l.thumbnail+'" alt="'+l.title+'"></div><div class="project_info"><h2>'+d+"</h2><p>"+n+'</p></div><div class="material_ids d-sm-none">'+l.hash_tags+"</div></div></div>"}$(".modal_slider").hasClass("slick-initialized")&&$(".modal_slider").slick("unslick"),$(".modal-dialog").last().after(a),s.current_page==s.last_page?$("#loadMore").hide():$("#loadMore").attr("data-href",s.next_page_url).show(),$(".not-loading").hide(),$(".project-list-view").last().after(i)}})}),equalheight=function(e){var i,a=0,s=0,o=[];$(e).each(function(){if(i=$(this),$(i).height("auto"),s!=(topPostion=i.position().top)){for(currentDiv=0;currentDiv<o.length;currentDiv++)o[currentDiv].height(a);o.length=0,s=topPostion,a=i.height(),o.push(i)}else o.push(i),a=a<i.height()?i.height():a;for(currentDiv=0;currentDiv<o.length;currentDiv++)o[currentDiv].height(a)})},$(window).on("load",function(){equalheight(".project_content p")}),$(window).resize(function(){equalheight(".project_content p")}),$(window).on("load",function(){equalheight(".blog_content a h2")}),$(window).resize(function(){equalheight(".blog_content a h2")}),$(document).on("click",".accept-cokkie",function(){document.cookie="acceptCookies=1",$(".cookies_bar").hide()}),$(document).on("click",".cookie-btn",function(){$(".cookies_bar").hide()}),$(".hero_img").on("beforeChange",function(e,i,a){$(".hero_img").addClass("works"),setTimeout(function(){$(".hero_img").removeClass("works")},1500)}),$(document).ready(function(){}),$("#formValidation").submit(function(e){e.preventDefault();var i=$("input[name=_token]").val(),a=$("input[name=name]").val(),s=$("input[name=email]").val(),o=$("input[name=mobile]").val(),t=$("textarea[name=message]").val(),l=$("input[name=captcha]").val(),d=$("input[name=csrfHidden]").val(),n=this.action;if(/^(\[url|https?:\/\/|www\.)/m.test(t))return alert("Please remove any url from message box"),!1;$.ajax({type:"POST",url:n,dataType:"json",data:{_token:i,name:a,email:s,mobile:o,message:t,captcha:l,csrfHidden:d},success:function(e){e.success&&($("#alert").html(e.success).fadeIn(2e3).fadeOut(4e3),document.getElementById("formValidation").reset()),$.ajax({type:"GET",url:SITE_URL+"reload-captcha",success:function(e){$(".captcha span").html(e.captcha)}})},error:function(e){let i=JSON.parse(e.responseText);$.map(i.errors,function(e,i){$("#"+i).addClass("is-invalid"),"captcha"==i&&$.ajax({type:"GET",url:SITE_URL+"reload-captcha",success:function(e){$(".captcha span").html(e.captcha)}})})}})}),window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","UA-252419676-1"),$(".contact-field").bind("cut copy paste",function(e){e.preventDefault()}),$("#reload").click(function(){$.ajax({type:"GET",url:SITE_URL+"reload-captcha",success:function(e){$(".captcha span").html(e.captcha)}})});