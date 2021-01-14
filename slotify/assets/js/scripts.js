// global variables

var currentPlaylist=new Array();
var shufflePlaylist=new Array();
var tempPlaylist=new Array();
var audioTag;
var mouseDown=false;
var currentIndex=0;
var repeat=false;
var shuffle=false;
var userLoggedIn;
var timer;

// evento que faz desaparecer o dropdown menu pelo scroll
$(window).scroll(function(){
	hideDropdwonMenu();//dropdown menu desaparece quando e feito scroll na pagina
})

// evento que faz desaparecer o dropdown menu pelo click
$(document).click(function(click){

	var target=$(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")){
			hideDropdwonMenu();//dropdown menu desaparece quando e feito scroll na pagina
	}

})

// evento que faz desaparecer o dropdown menu pelo click
$(document).change(function(){

	var select=$("select.playlist");

	var playlistId=select.val();
	var songId=select.prev(".songId").val();

	if(playlistId && songId){
		
		$.post('includes/handlers/ajax/createPlaylistSongsJson.php',{songId:songId,playlistId:playlistId})
		.done(function(success){

			if(success != null){
				alert(success);
			}

			hideDropdwonMenu();
			select.val("");

			// openPage('yourMusic.php');
		});

	}
	else{
		// alert('Choose a valid option');
	}



})

function updateEmail(emailClass){
	var emailValue=$("."+emailClass).val();
	$.post('includes/handlers/ajax/updateUserEmailJson.php',{email:emailValue,userLoggedIn:userLoggedIn})
	.done(function(success){
		if(success != null){
			alert(success);
		}

		openPage('profile.php');
	});
}

function updateUserPassword(oldPwdClass,newPwdClass,confNewPwdClass){
	var oldPassword=$("."+oldPwdClass).val();
	var newPassword=$("."+newPwdClass).val();
	var confirmPassword=$("."+confNewPwdClass).val();

	if(newPassword != confirmPassword){
		alert('Your new password and confirm password provided does not match!');
		return;
	}

	$.post('includes/handlers/ajax/updateUserPasswordJson.php',{oldPassword:oldPassword,newPassword:newPassword,userLoggedIn:userLoggedIn})
	.done(function(success){
		if(success != null){
			alert(success);
		}

		openPage('profile.php');
	});
}
// logout
function logout(){
	$.post('includes/handlers/ajax/logoutJson.php',function(){
		location.reload();
	})
}

// open page without refresh da page

function openPage(url){

if (timer != null) {
	clearTimeout(timer);
}
	if(url.indexOf('?')==-1){
		url=url + "?";
	}
	var encondedUrl=encodeURI(url+'?&userLoggedIn='+userLoggedIn);

	$("#mainContent").load(encondedUrl);
	$("body").scrollTop(0);

	// update the url on browser
	history.pushState(null,null,url);
}

function removeFromPlaylist(button,playlistId){

		var songId=$(button).prevAll('.songId').val();


		$.post('includes/handlers/ajax/removeFromPlaylistJson.php',{songId:songId,playlistId:playlistId})
		.done(function(success){
			if(success != null){
				alert(success);
			}

			openPage('playlist.php?id='+playlistId);
		});

}
// criar uma playlist
function createPlaylist(){
	var playlistName=prompt("Enter the name of your playlist");

	if(playlistName != null){
		

		$.post('includes/handlers/ajax/createPlaylistJson.php',{name:playlistName,owner:userLoggedIn})
		.done(function(success){
			if(success != null){
				alert(success);
			}

			openPage('yourMusic.php');
		});

	}
}

// excluir uma playlist
function deletePlaylist(playlistId){

		var canDelete=confirm("Do your realy want to delete a playlist?");

		if(canDelete){

			$.post('includes/handlers/ajax/deletePlaylistJson.php',{playlistId:playlistId})
			.done(function(success){
				if(success != null){
					alert(success);
				}

				openPage('yourMusic.php');
			});

		}
}

// show dropdown menu
function showDropdownMenu(button){
	var songId=$(button).prevAll('.songId').val();

	var menu=$('.optionsMenu');

	menu.find(".songId").val(songId);

	var menuWidth=menu.width();
	var scrollTop=$(window).scrollTop();
	var elementOffset=$(button).offset().top;
	var top=elementOffset - scrollTop;
	var left=$(button).position().left;
	menu.css({"top":top+"px", "left":left - menuWidth +"px", "display":"inline"});
}

// hide dropdown menu
function hideDropdwonMenu(){
		var menu=$('.optionsMenu');
		if(menu.css("display") != "none"){
			menu.css("display","none");
		}
}
// formata a duração de uma musica
function formatTime(seconds){
	var time=Math.round(seconds);
	var minutes=Math.floor(time/60);//arredonda para baixo
	var seconds=time - (minutes*60);

	var extraZero=(seconds < 10) ? extraZero="0" : extraZero="";

	return minutes+':'+extraZero+seconds;
}

// actualiza o tempo real do audio
function updateTimeProgressBar(audio){

	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress=(audio.currentTime/audio.duration)*100;

	$(".playbackBar .progress").css("width",progress+"%");
}

// actualiza o volume da barra de progresso
function updateVolumeProgressBar(audio){
	var volume=audio.volume*100;

	$(".volumeBar .progress").css("width",volume+"%");
}

// plays first song on artist page, if we click button
function playArtistFirstSong(){
	setMusic(tempPlaylist[0],tempPlaylist,true);
}
// audio class in javascript
function Audio(){

	// proprieties
	this.currentlyPlayingSong;
	this.audio=document.createElement("audio");//criando uma tag audio(Elemento html)


	// adicionando event listener ao objecto audio para trazer a duração total do audio
	this.audio.addEventListener('ended',function(){

		nextSong();

	});

	// adicionando event listener ao objecto audio para trazer a duração total do audio
	this.audio.addEventListener('canplay',function(){
		$(".progressTime.remaining").text(formatTime(this.duration));

	});

	// adicionando event listener ao objecto audio
	this.audio.addEventListener('timeupdate',function(){
		if(this.duration){
			updateTimeProgressBar(this);
		}
	});

	// adicionando event listener ao objecto audio para mudar o volume
	this.audio.addEventListener('volumechange',function(){
			updateVolumeProgressBar(this);
	});



	//função para setar a musica 
	this.setTrack = function(track){
		this.currentlyPlayingSong=track;
		this.audio.src=track.path;

	}

	//função para setar a o tempo da musica 
	this.setTime = function(seconds){
		this.audio.currentTime=seconds;
	}

	//função para dar play a musica 
	this.play=function(){
		this.audio.play();
	}

	//função para pausar a musica 
	this.pause=function(){
		this.audio.pause();
	}
}