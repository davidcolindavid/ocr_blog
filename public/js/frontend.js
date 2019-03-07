// Animation au démarrage de la page
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




// Réorganise le DOM pour la mise en page des billets
// 2 billets dans un même conteneur
$(".listPostsContainer").append('<div class="row listPostsRow1"></div>');
$(".listPostsContainer").append('<div class="row listPostsRow2"></div>');
$(".listPostsRow1").append( $('.section1'), $('.section2') );
$(".listPostsRow2").append( $('.section3'), $('.section4') );
$(".contact").insertAfter($(".listPostsRow1"));
$(".listPostsRow1").append( $('.cache1') );
$(".listPostsRow2").append( $('.cache2') );



// Slider formulaire de contact
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


// Slide description au blog
$(".blog_description").css("display", "none");
let degrees = 0;

$("#blog_author, #plus .fa-plus").on('click', function () {
	$(".blog_description").slideToggle();
	degrees = degrees + 45;
	document.querySelector(".fa-plus").style.transition = "transform 0.3s";
    document.querySelector(".fa-plus").style.transform = 'rotate(' + degrees + 'deg)';	
})



// Billet au survole
if ($(".section2").length) {
	document.querySelector(".section2").addEventListener('mouseover', function () {
		document.querySelector(".cache1").style.transition = 'transform 0.3s' 
		document.querySelector(".cache1").style.transform = 'translate3D(100%,0,0)' 
	})
}

if ($(".section1").length) {
	document.querySelector(".section1").addEventListener('mouseover', function () {
		document.querySelector(".cache1").style.transition = 'transform 0.3s' 
		document.querySelector(".cache1").style.transform = 'translate3D(0,0,0)' 
	})
}

if ($(".section4").length) {
	document.querySelector(".section4").addEventListener('mouseover', function () {
		document.querySelector(".cache2").style.transition = 'transform 0.3s' 
		document.querySelector(".cache2").style.transform = 'translate3D(100%,0,0)' 
	})
}

if ($(".section3").length) {
	document.querySelector(".section3").addEventListener('mouseover', function () {
		document.querySelector(".cache2").style.transition = 'transform 0.3s' 
		document.querySelector(".cache2").style.transform = 'translate3D(0,0,0)' 
	})
}

// Ancre / scroll vers les commentaires
$(document).ready( function () {
	$('.comments_target').click(function() {
	  $('html,body').animate({scrollTop: ( $(".container_comment_form").offset().top - $("#bar").height() )}, 'slow'      );
	});  
 })