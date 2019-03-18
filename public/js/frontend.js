// Entrance Animation
if (sessionStorage.getItem("animation")) {
	$("#cover").css('display', 'none');
	
	$("#bar").delay().animate({ 
		top: "0",
	},500);
} else {
	let rightPos = ($(window).width() - ($('#cover h1').offset().left + $('#cover h1').outerWidth()));

	$("#cover h1").delay(600).animate({ 
		left: rightPos,
	},2000);

	$("#cover h1").delay(300).animate({ 
		top: "-100%",
	},1000);

	$("#cover").delay(2900).animate({ 
		top: "-100%",
	},1000).fadeOut();

	$("#bar").delay(3600).animate({ 
		top: "0",
	},1000);

	sessionStorage.setItem('animation', 'skip');
}


// Modify the DOM
// 2 posts in the same container
$(".listPostsContainer1").append('<div class="row listPostsRow1"></div>');
$(".listPostsContainer2").append('<div class="row listPostsRow2"></div>');
$(".listPostsRow1").append( $('.post1'), $('.post2') );
$(".listPostsRow2").append( $('.post3'), $('.post4') );
$(".contact").insertAfter($(".listPostsContainer1"));
$(".listPostsRow1").append( $('.cache1') );
$(".listPostsRow2").append( $('.cache2') );


// Slider contact
class Slider {
    constructor() {
		$('#btn_contact').wi
		this.btnContact = document.querySelector('#btn_contact')
		this.slideRight();
	}

	slideRight() {
		this.btnContact.addEventListener('click', function () {
			$(".contact_container").animate({ 
				marginLeft: "-100%",
			},300);
		})
  }
}

if ($("#btn_contact").length) {
	const contact = new Slider ()
}

if ($('.contact_send').length) {
	$('.contact_send').on('submit', function(e) {
		e.preventDefault();
		let formElt = $(this);
		let url = formElt.attr('action');
		let email = document.querySelector('#email');
		let message = document.querySelector('#message');

		// check if the fields username et password are empties
		if (email.value.trim().length === 0 || message.value.trim().length === 0) {
				// report username if empty
				if (email.value.length === 0) {
					email.style.border = "4px dotted #000000";
					email.addEventListener("focus", function () {
						email.style.border = "4px solid #000000";
					}) 
				// report password if empty
				} else if (message.value.length === 0) {
					message.style.border = "4px dotted #000000";
					message.addEventListener("click", function () {
							message.style.border = "4px solid #000000";
					})
				}
		} else {
				$.ajax({
						type: "POST",
						url: url,
						data: formElt.serializeArray(),
						success: function(response) {
								if(response=="success")
								{	
									$(".contact_message").html('Email envoyé')
									$(".contact_send")[0].reset()
									$('.contact_message').slideDown();
									$('.contact_message').delay(2000).slideUp();
								}
								else
								{   
									$(".contact_message").html('Email invalide')
									$('.contact_message').slideDown();
									$('.contact_message').delay(2000).slideUp();							}
						},
								
				})
		}
	});
}

// Slide blog description
$(".blog_description").css("display", "none");
let degrees = 0;

$("#blog_author, #plus .fa-plus").on('click', function () {
	$(".blog_description").slideToggle();
	degrees = degrees + 45;
	document.querySelector(".fa-plus").style.transition = "transform 0.3s";
    document.querySelector(".fa-plus").style.transform = 'rotate(' + degrees + 'deg)';	
})


// Mouseover slide post
if ($(".post2").length) {
	document.querySelector(".post2").addEventListener('mouseover', function () {
		document.querySelector(".cache1").style.transition = 'transform 0.3s' 
		document.querySelector(".cache1").style.transform = 'translate3D(100%,0,0)' 
	})
}

if ($(".post1").length) {
	document.querySelector(".post1").addEventListener('mouseover', function () {
		document.querySelector(".cache1").style.transition = 'transform 0.3s' 
		document.querySelector(".cache1").style.transform = 'translate3D(0,0,0)' 
	})
}

if ($(".post4").length) {
	document.querySelector(".post4").addEventListener('mouseover', function () {
		document.querySelector(".cache2").style.transition = 'transform 0.3s' 
		document.querySelector(".cache2").style.transform = 'translate3D(100%,0,0)' 
	})
}

if ($(".post3").length) {
	document.querySelector(".post3").addEventListener('mouseover', function () {
		document.querySelector(".cache2").style.transition = 'transform 0.3s' 
		document.querySelector(".cache2").style.transform = 'translate3D(0,0,0)' 
	})
}


// Comments target / Scroll to the comments
$(document).ready( function () {
	$('.comments_target').click(function() {
	  $('html,body').animate({scrollTop: ( $(".container_comment_form").offset().top - $("#bar").height() )}, 'slow');
	});  
})