
<?php
    require '/home/robert/config/conn.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $sql="SELECT * FROM nota";
    $result = mysqli_query($mysqli,$sql);
    //echo $result;

    while($row = $result->fetch_array())
    {
        $rows[] = $row;
    }
?>
<html>
<head>
    <title>Big O Notation</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <script language="javascript" type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script language="javascript" type="text/javascript" src="logic.js"></script>
    <script>
        var arr = [];
        <?php foreach ($rows as $row) : ?>
            arr.push(['<?php echo $row['notation']?>', '<?php echo             $row['name']?>', <?php echo $row['ord']?>]);
        <?php endforeach; ?>
        
        var correct = 1;
        var total = 1;
        
        var sign  = [">","<"];
        
        var currentLeft = 0;
        
        var currentRight = 1;
        
        document.onkeydown = function(e) {
            switch (e.keyCode) {
                case 37:
                    popBut(0);
                    break;
                case 39:
                    popBut(1);
                    break;
            }
        };
        
        
    function popBut(clickedBut){
        
        updateSB(clickedBut);
        
        currentLeft = Math.floor(Math.random() * arr.length);
        do {
            currentRight = Math.floor(Math.random() * arr.length);
        } while(currentRight == currentLeft);
        
        console.log("left"+currentLeft+"right"+currentRight);

        document.getElementById("leftBut").innerHTML = arr[currentLeft][0];
        
        document.getElementById("rightBut").innerHTML = arr[currentRight][0];
    }
        
    function updateSB(clickedBut){
        
        var leftOrd = arr[currentLeft][2];
        var rightOrd = arr[currentRight][2];
        
        var corr = calcCorrect(clickedBut,leftOrd,rightOrd);
        
        var opString = "<tr><td>"+arr[currentLeft][0]+" "+sign[clickedBut]+" "+arr[currentRight][0]+"</td><td>";
        
        if(corr){
          $("#scoreQueue tr:first").before(opString+ "&#9989</td></tr>");
            correct++;
            total++;
        } else {
          $("#scoreQueue tr:first").before(opString+ "&#10060</td></tr>");
            total++;
        }
        
        $( "table tr:nth-child(7)" ).remove();
        
        document.getElementById("acc").innerHTML = Math.floor((correct/total)*100) + "%";
    };
        
    function calcCorrect(clickedBut,leftOrd,rightOrd){
        if(clickedBut == 0){
            if(leftOrd > rightOrd)
                return true;
            else
                return false;
        } else {
            if(rightOrd > leftOrd)
                return true;
            else
                return false;
        }
    }
        
    
    
    </script>
</head>
<body>
    <h1 class="headr">Which is greater?</h1>
    <div class="choiceContainer" id="choiceContainer">
        <div class="choice" name="leftchoice" id="left">
            <button id="leftBut" onclick="popBut(0);" class="button choiceButton">O(log n)</button>
        </div>
        <span id="op" class="opContainer">OR</span>
        <div class="choice" name="rightchoice" id="right">
            <button id="rightBut" onclick="popBut(1)" class="button choiceButton">O(n)</button>
        </div>
    </div>
    <br>
    <div id="scoreboard">
        Accuracy: <span id="acc"></span>
    </div>
    
    <div id="sbContainer">
        <table class="table" id="scoreQueue">
            <tbody>
                <tr class="notationRow">
                </tr>
            </tbody>
        </table>
    </div>

    
</body>
</html>