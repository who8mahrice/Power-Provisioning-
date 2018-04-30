<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Power Provisioning</title>
        <style type="text/css">
            
            * {
                margin: 0;
                padding: 0;
            }
            
            body {
                font-family: Open Sans, Arial, sans-serif;
                overflow-x: hidden;
            }
            
            nav {
                position: fixed;
                z-index: 1000;
                top: 0;
                bottom: 0;
                width: 200px;
                background-color: #036;
                transform: translate3d(-200px, 0, 0);
                transition: transform 0.4s ease;
            }

            .active-nav nav {
                transform: translate3d(0, 0, 0);
            }

            nav ul {
                list-style: none;
                margin-top: 100px;
            }

            nav ul li a {
                text-decoration: none;
                display: block;
                text-align: center;
                color: #fff;
                padding: 10px 0;
            }
            
            .nav-toggle-btn {
                display: block;
                position: absolute;
                left: 200px;
                width: 40px;
                height: 40px;
                background-color: #666;
            }


            /*START This is the old active-nav transition, new one is .active-nav #content */
            .active-nav .content {
                transform: translate3d(200px, 0, 0);
            }
            /*END This is the old active-nav transition, new one is .active-nav #content */
            
            /*Use this one */ 
            .active-nav #content {
                transform: translate3d(200px, 0, 0);
            }
            


             #content {
                background-color : white;
            }
            

            h2 {
                 padding-top: 10px; 
               /* height: 100px;*/
                background-color: #ccf;
                text-align: left;
                transition: transform 0.4s ease;
            }
            
            
        </style>
    </head>

    <body>
        
        <nav>
            
            <a href="#" class="nav-toggle-btn"></a>
            
            <ul>
                <li><a href="new_customer.php">New Customer</a></li>
                <li><a href="spaceproduct.php">Add Space</a></li>
                <li><a href='powerproduct.php'>Add Power</a></li>
                <li><a href="query.php">Query Customer</a></li>
            </ul>
            
        </nav>
        

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
        
        (function() {
            
            var bodyEl = $('body'),
                navToggleBtn = bodyEl.find('.nav-toggle-btn');
            
            navToggleBtn.on('click', function(e) {
                bodyEl.toggleClass('active-nav');
                e.preventDefault();
            });
        })();  

    </script>
    </body>
</html>
