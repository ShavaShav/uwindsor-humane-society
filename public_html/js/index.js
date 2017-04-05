window.addEventListener("load", function() {
    var d = new Date();
    var text = "";
    
    if (d.getHours() < 6)
        text = "<b>You should be sleeping! ;)</b>";
    else if (d.getHours() < 12)
        text = "<b>Good Morning!</b>";
    else if (d.getHours() < 18)
        text = "<b>Good Afternoon!</b>";
    else
        text = "<b>Have a good evening!</b><br> We are currently closed, but our website is always open!";
    document.getElementById("greetingMsg").innerHTML=text;
});