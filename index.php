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
<body>

<script>
    
<button class='btn-contact btn btn-success' style ='background-color: #goldenrod; border: none;' onclick='startGame()'>Start Game</button>


    var mybird;
    var myobstacles = [];
    var myScore = 0;
    var myHighScore = 0;

    var gameScreen;


    function startGame() {
        mybird = new component (30, 30, blue, 0, 0)
        mybird.gravity =
        myScore = new component ()
        gamearea.start();
    }


    function component(height, width, color, x, y, type) {
        this.height = height
        this.width = width
        this.color = color
        this.x = x
        this.y = y
        this.type = type
        this.gravity = 0
        this.gravity_speed = 0
        this.SpeedX = 0;
        this.SpeedY = 0;
    }






</script>
<br>

<button onmousedown="accelerate(-0.2)" onmouseup="accelerate(0.05)">ACCELERATE</button>
<p>Use the ACCELERATE button to stay in the air</p>
<p>How long can you stay alive?</p>
</body>
</html>
