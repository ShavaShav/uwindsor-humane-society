window.addEventListener("load", function() {
    var d = new Date();
    var text = "";
    
    var box = document.getElementById("greetingBox");
    
    if (d.getHours() < 6){
        box.className = "night";
        text = "<b>You should be sleeping! ;)</b>";
    } else if (d.getHours() < 12) {
        box.className = "morning";
        text = "<b>Good Morning!</b>";
    }
    else if (d.getHours() < 18){
        box.className = "night";
        text = "<b>Good Afternoon!</b>";
    }
    else {
        box.className = "evening";
        text = "<b>Have a good evening!</b><br> We are currently closed, but our website is always open!";
    }
    
    document.getElementById("greetingMsg").innerHTML=text;
});