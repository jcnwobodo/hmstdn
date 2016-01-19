<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date: 10/4/2015
 * Time: 12:17 PM
 */

include_once('header.php');
?>

    <div class="container-fluid ">
    

        <div class="row">
        <div class="col-md-8" style="">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="Assets/images/slider.jpg" alt="">
                        <div class="carousel-caption">
                            ANPC
                        </div>
                    </div>
                    <div class="item">
                        <img src="Assets/images/slider-1.jpg" alt="">
                        <div class="carousel-caption">
                            ANPC
                        </div>
                    </div>
                    <div class="item">
                        <img src="Assets/images/slider-2.jpg" alt="">
                        <div class="carousel-caption">
                            Vote for the Best Poll
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#carousel-example" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                        <span class="sr-only">previous</span>
                        
                </a>
                <a class="right carousel-control" href="#carousel-example" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                        <span class="sr-only">next</span>
                        
                </a>
            </div>
            
        </div>
        <div class="col-md-4">
            <div class="row col-md-12">
                        <hr/>

            </div>
            <div class="col-md-10">
            <h2>Polls</h2>
            <h5>Ongoing Polls</h5>
            <h6>Caption 1</h6>
            <h6>Caption 1</h6>
            <hr/>
            <h5>Upcoming Polls</h5>
            <h6>Caption 1</h6>
            <h6>Caption 1</h6>  
            <hr/>
            </div>
            <div class="col-md-10">
                <h3>Resolution</h3>
                <hr/>
                <h3>Press Room</h3>
            </div>
            
            <div class="row col-md-12">
            <hr/>
            <h6><a target="_blank" href="www.facebook.com/anpc"><img src="Assets/images/facebook.png"></a>
            <a target="_blank" href="www.facebook.com/anpc"><img src="Assets/images/twitter.png"></a></h6>
            <hr/>
            <div class="input-group col-md-10">
                
                <input type="email" placeHolder="Email subcription" class="form-control" aria-label="Email">
                <!--<input type="email" placeHolder="Email" class="form-control" aria-label="Email">-->
                <div class="input-group-btn">
                    <button class="btn btn-default">Subscribe</button>
                </div>
            </div>
            <!--<h6><a><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Notification  service</a> </h6>-->
            <hr/>
            <h6><a href="<?php home_url('/login')?>"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Login/Sign up Form</a></h6>
            <!--<span class="glyphicon glyphicon-briefcase"></span>-->
            <!--<span class="glyphicon glyphicon-file"></span>-->
            </div>
        </div>
            </div>
    
    <div class="row">
        <div class="col-md-8">
        
            </div>
        <div class="col-md-4">
            
            
        </div>
    </div>
    

</div>

<?php include_once("footer.php"); ?>