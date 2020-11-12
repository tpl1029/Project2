<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
canvas {
    border:1px solid #d3d3d3;
    background-color: #f1f1f1;
}
</style>
</head>
<body onload="loadgame()">
<?php

session_start();

if(isset($_POST["name"])) 
setcookie("username", trim(htmlentities($_POST['name'])), time()+(86400 * 30), "/");
echo " <p> The value in the cookie is {$_COOKIE['username']}  </p>"; 

?>
<img id='bird' width='50' height='50' style="display: none" src="./Public/Images/flappy-bird.gif">

<audio id="audio" src="./Public/Sounds/bonk2.mp3"></audio>
<button onclick='play()'>BONK</button>

<button onclick="displayForm()">HideTest</button>

<script>
var img = document.getElementById("bird")

var myGamePiece;
var myObstacles = [];
var myScore;
var hide;

function loadgame(){
    myGameArea.start();
    
}

function startGame() {
    myGamePiece = new component(30, 30, "./Public/Images/flappy-bird.gif", 10, 120, "image");
    myGamePiece.gravity = 0.05;
    myScore = new component("30px", "Consolas", "black", 280, 40, "text");
    myBackground = new component(656, 270, "./Public/Images/background.png", 0, 0, "background" );    
}


var myGameArea = {
    canvas : document.createElement("canvas"),
    start : function() {
        this.canvas.width = 480;
        this.canvas.height = 270;
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.frameNo = 0;
        this.interval = setInterval(updateGameArea, 20);
        },
    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
}

function component(width, height, color, x, y, type) {
    this.type = type;
        if (type == "image" || type == "background") {
            this.image = new Image();
            this.image.src = color;
        }

    this.score = 0;
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;    
    this.x = x;
    this.y = y;
    this.gravity = 0;
    this.gravitySpeed = 0;
    this.update = function() {
        ctx = myGameArea.context;
        if (this.type == "text") {
            ctx.font = this.width + " " + this.height;
            ctx.fillStyle = color;
            ctx.fillText(this.text, this.x, this.y);
        } else {
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }
        if (type == "image" || type == "background") {
            ctx.drawImage(this.image, this.x, this.y, this.width, this.height);
            if (type =="background") {
            ctx.drawImage(this.image, this.x + this.width, this.y, this.width, this.height);
        }
        } else {
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }
    }
    this.newPos = function() {
        this.gravitySpeed += this.gravity;
        this.x += this.speedX;
        this.y += this.speedY + this.gravitySpeed;
        if(this.type =="background"){
            if(this.x == -(this.width)) {
                this.x = 0;
            }
        }
        this.hitBottom();
        this.hitTop();
    }

    this.hitTop = function() {
        var topMax = myGameArea.canvas.height;
        if (this.y < 0) {
            this.y = 0;
            this.gravitySpeed = 0;          
        }
    }


    this.hitBottom = function() {
        var rockbottom = myGameArea.canvas.height - this.height;
        if (this.y > rockbottom) {
            this.y = rockbottom;
            this.gravitySpeed = 0;  
        }
    }


    this.crashWith = function(otherobj) {
        var myleft = this.x;
        var myright = this.x + (this.width);
        var mytop = this.y;
        var mybottom = this.y + (this.height);
        var otherleft = otherobj.x;
        var otherright = otherobj.x + (otherobj.width);
        var othertop = otherobj.y;
        var otherbottom = otherobj.y + (otherobj.height);
        var crash = true;
        if ((mybottom < othertop) || (mytop > otherbottom) || (myright < otherleft) || (myleft > otherright)) {
            crash = false; 
        }
        // displayForever();
        //console.log(this.y);
        return crash;

    }
}

var testScore = -3;

function updateGameArea() {
    var x, height, gap, minHeight, maxHeight, minGap, maxGap;
    for (i = 0; i < myObstacles.length; i += 1) {
        if (myGamePiece.crashWith(myObstacles[i])) {
            displayForever();
            retry();
            return;
        } 
    }
    myGameArea.clear();
    myBackground.speedX = -1;
    myBackground.newPos();
    myBackground.update();
    myGameArea.frameNo += 1;
    if (myGameArea.frameNo == 1 || everyinterval(150)) {
        x = myGameArea.canvas.width;
        minHeight = 20;
        maxHeight = 200;
        height = Math.floor(Math.random()*(maxHeight-minHeight+1)+minHeight);
        minGap = 50;
        maxGap = 200;
        gap = Math.floor(Math.random()*(maxGap-minGap+1)+minGap);
        myObstacles.push(new component(10, height, "green", x, 0));
        myObstacles.push(new component(10, x - height - gap, "green", x, height + gap));
        testScore++;
        console.log(testScore);
    }
    for (i = 0; i < myObstacles.length; i += 1) {
        myObstacles[i].x += -1;
        myObstacles[i].update();
    }
    // myScore.text="SCORE: " + myGameArea.frameNo;
    myScore.text="SCORE: " + testScore;
    myScore.update();
    myGamePiece.newPos();
    myGamePiece.update();


}

function everyinterval(n) {
    if ((myGameArea.frameNo / n) % 1 == 0) {return true;}
    return false;
}

function accelerate(n) {
    myGamePiece.gravity = n;
}

// function sound(src) {
//     this.sound = documentcreateElement("audio");
//     this.sound.src = src;
//     this.sound.setAttribute("preload", "auto");
//     this.sound.setAttribute("controls", "none");
//     this.sound.style.display = "none";
//     document.body.appendChild(this.sound);
//     this.play = function() {
//         this.sound.play();
//     }
//     this.stop = function() {
//         this.sound.pause();
//     }
// }

function play() {
        var audio = document.getElementById("audio");
        audio.play();
};

function displayForm() {
  var x = document.getElementById("myForm");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function displayForever() {
    var x = document.getElementById("myForm");
  if (x.style.display === "none") {
    x.style.display = "block";
  }
}

function retry(){
    var x = document.getElementById("retry_btn");
  if (x.style.display === "none") {
    x.style.display = "block";
  }

  
}

</script>


<button onclick="startGame()">Start the Game!</button>
<button onmousedown="accelerate(-0.8)" onmouseup="accelerate(0.05)">ACCELERATE</button>
<button onclick="location.reload();" id="retry_btn" style="display: none">Try Again?</button>
<p>Use the ACCELERATE button to stay in the air</p>
<p>How long can you stay alive?</p>



<div id="myForm" style="display: none">
  <form action="" method = "post">
    <label for="name"><b>Please Enter Your Name</b></label>
    <input type="text" placeholder="Enter Name" name="name" required>
    <button type="submit" class="btn">Go!</button>
      </form>
</div> 



</body>
</html>
