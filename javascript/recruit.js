$(window).load(function () {
            //Get offset of container. Use to set affix offset value.
            $("#menu").attr("data-spy", "affix");
            $("#menu").attr("data-offset-top", $("#other_content").offset().top);
            $("body").scrollspy({target: "#menu", offset: -$("#other_content").height()/10000 + 10})
        })