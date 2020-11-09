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

<button class='btn-contact btn btn-success' style ='background-color: #goldenrod; border: none;' onclick='startGame()'>Start Game</button>

<script>

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


