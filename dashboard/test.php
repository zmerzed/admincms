<html>
    <head>
    <script src="/js/jspdf.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    </head>
    <body>
    <div id="pdf">
              <div> test 1 test 2</div>
    </div>
    <canvas id="myCanvas" width="200" height="100" style="border:1px solid #000000;">
</canvas>
    <button onclick="takeScreenShot()">to image</button>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var c = document.getElementById("myCanvas");
        var ctx = c.getContext("2d");
        ctx.moveTo(0, 0);
        ctx.lineTo(200, 100);
        ctx.stroke();
    </script>

    <script>
           //var doc = new jsPDF();
              

                window.takeScreenShot = function() {

                    html2canvas(document.querySelector("#pdf")).then(canvas => {
                        document.body.appendChild(canvas)
                        var w = document.getElementById("pdf").offsetWidth;
                        var h = document.getElementById("pdf").offsetHeight;
                        var img = canvas.toDataURL("image/jpeg", 1);
                        var doc = new jsPDF('L', 'px', [w, h]);
                        doc.addImage(img, 'JPEG', 0, 0, w, h);
                        doc.save('sample-file.pdf');
                    });
                }
    </script>
</html>