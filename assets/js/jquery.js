
$(document).ready(function () {
    
    $("#carreebleu").hide();
    $("#carrbts").hide();
    $("#legende").hide();

    $("a#afficher").on('click', function () {
        $("#carreebleu").show("fast");
        $("#carrbts").show("fast");
        $("#legende").show("fast");
        $("#chargement").hide();
        return false;
    });
    
});

