<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>.loader {
        /* the colors */
        --c1: #fff70d;
        --c2: #fb1313;
        --c3: #1be19c;
        --c4: #81e410;
        /**/

        width: 40px; /* control the size */
        aspect-ratio: 8/5;
        --_g: no-repeat radial-gradient(#000 68%,#0000 71%);
        -webkit-mask: var(--_g),var(--_g),var(--_g);
        -webkit-mask-size: 25% 40%;
        background:
          conic-gradient(var(--c1) 50%,var(--c2) 0) no-repeat,
          conic-gradient(var(--c3) 50%,var(--c4) 0) no-repeat;
        background-size: 200% 50%;
        animation:
          back 4s infinite steps(1),
          load 2s infinite;
      }

      @keyframes load {
        0%    {-webkit-mask-position: 0% 0%  ,50% 0%  ,100% 0%  }
        16.67%{-webkit-mask-position: 0% 100%,50% 0%  ,100% 0%  }
        33.33%{-webkit-mask-position: 0% 100%,50% 100%,100% 0%  }
        50%   {-webkit-mask-position: 0% 100%,50% 100%,100% 100%}
        66.67%{-webkit-mask-position: 0% 0%  ,50% 100%,100% 100%}
        83.33%{-webkit-mask-position: 0% 0%  ,50% 0%  ,100% 100%}
        100%  {-webkit-mask-position: 0% 0%  ,50% 0%  ,100% 0%  }
      }
      @keyframes back {
        0%,
        100%{background-position: 0%   0%,0%   100%}
        25% {background-position: 100% 0%,0%   100%}
        50% {background-position: 100% 0%,100% 100%}
        75% {background-position: 0%   0%,100% 100%}
      }



      body {
        margin:0;
        /* min-height:100vh; */
        display:grid;
        place-content:center;
      }
      </style>
</head>
<body>
    <div>
        <center>
        <h1 >Coming Soon....</h1>
        <div class='loader'></div>
        </center>
    </div>
</body>
</html>
