<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Join TMK 4H Community</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}


body{

    min-height:100vh;

    background:
    linear-gradient(
        rgba(0,0,0,.78),
        rgba(0,0,0,.92)
    ),
    radial-gradient(
        circle at top,
        #1b1b1b,
        #050505 70%
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;

    padding:120px 20px 80px;

    overflow-y:auto;

}



/* LOGO */

.logo{

    position:absolute;

    top:35px;

    left:45px;

    color:#168cff;

    font-size:38px;

    font-weight:900;

    letter-spacing:-2px;

    line-height:.9;

}


.community{

    display:block;

    color:#aaa;

    font-size:14px;

    letter-spacing:3px;

    font-weight:500;

    margin-left:4px;

    margin-bottom:6px;

}





/* JOIN BOX */

.join-box{

    width:480px;

    max-width:100%;

    padding:45px;

    background:rgba(15,15,15,.88);

    border-radius:12px;

    box-shadow:
    0 20px 60px rgba(0,0,0,.8);

}



.join-box h1{

    font-size:32px;

    margin-bottom:25px;

}





/* INPUTS */

.input,
select{


    width:100%;

    padding:15px;

    margin-bottom:15px;

    border-radius:5px;

    border:1px solid #444;

    background:#222;

    color:white;

    font-size:15px;

}


.input::placeholder{

    color:#888;

}


.input:focus,
select:focus{

    outline:none;

    border-color:#168cff;

}



select{

    cursor:pointer;

}



select option{

    background:#222;

    color:white;

}





/* INTERESTS */

.interest-title{

    color:#aaa;

    font-size:14px;

    margin:15px 0 12px;

}


.interests{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:10px;

}


.interest{

    padding:10px;

    background:#222;

    border:1px solid #333;

    border-radius:6px;

    color:#ddd;

    cursor:pointer;

}



.interest input{

    accent-color:#168cff;

}





/* BUTTON */

button{


    width:100%;

    margin-top:25px;

    padding:15px;

    border:none;

    border-radius:5px;

    background:#168cff;

    color:white;

    font-size:17px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

}



button:hover{

    background:#006fe6;

}






/* LOGIN */

.login{

    margin-top:25px;

    text-align:center;

    color:#aaa;

}



.login a{

    color:white;

    text-decoration:none;

}



.login a:hover{

    color:#168cff;

}





/* FOOTER */

.footer{

    position:fixed;

    bottom:15px;

    left:0;

    width:100%;

    text-align:center;

    color:#777;

    font-size:13px;

}





/* TABLET */

@media(max-width:768px){


.logo{

    top:25px;

    left:30px;

    font-size:34px;

}


.join-box{

    width:90%;

    padding:40px;

}


}






/* PHONE */

@media(max-width:500px){


body{

    padding:100px 15px 70px;

    align-items:flex-start;

}



.logo{

    top:20px;

    left:20px;

    font-size:30px;

}



.community{

    font-size:11px;

}



.join-box{

    width:100%;

    max-width:380px;

    padding:30px 22px;

    margin-top:20px;

}



.join-box h1{

    font-size:26px;

}



.input,
select{

    padding:14px;

}



.interests{

    grid-template-columns:1fr;

}



button{

    padding:14px;

}



.footer{

    font-size:11px;

    bottom:8px;

}


}





/* SMALL PHONE */

@media(max-width:360px){


.logo{

    font-size:26px;

}


.join-box{

    padding:25px 18px;

}


}


</style>

</head>


<body>



<div class="logo">

<span class="community">
community
</span>

TMK 4H

</div>






<div class="join-box">


<h1>Create Account</h1>



<input class="input" placeholder="Full name">


<input class="input" placeholder="Username">


<input class="input" type="email" placeholder="Email address">


<input class="input" type="password" placeholder="Password">





<select class="input">

<option>
Select nationality
</option>


<!-- Arab Countries -->

<option>Algeria</option>
<option>Bahrain</option>
<option>Comoros</option>
<option>Djibouti</option>
<option>Egypt</option>
<option>Iraq</option>
<option>Jordan</option>
<option>Kuwait</option>
<option>Lebanon</option>
<option>Libya</option>
<option>Mauritania</option>
<option>Morocco</option>
<option>Oman</option>
<option>Palestine</option>
<option>Qatar</option>
<option>Saudi Arabia</option>
<option>Somalia</option>
<option>Sudan</option>
<option>Syria</option>
<option>Tunisia</option>
<option>United Arab Emirates</option>
<option>Yemen</option>


<!-- Top World Countries -->

<option>United States</option>
<option>Canada</option>
<option>Mexico</option>

<option>United Kingdom</option>
<option>France</option>
<option>Germany</option>
<option>Italy</option>
<option>Spain</option>
<option>Portugal</option>
<option>Netherlands</option>
<option>Switzerland</option>
<option>Sweden</option>
<option>Norway</option>
<option>Denmark</option>
<option>Poland</option>


<option>China</option>
<option>Japan</option>
<option>South Korea</option>
<option>India</option>
<option>Pakistan</option>
<option>Bangladesh</option>
<option>Indonesia</option>
<option>Malaysia</option>
<option>Singapore</option>
<option>Thailand</option>
<option>Vietnam</option>
<option>Philippines</option>
<option>Turkey</option>


<option>Brazil</option>
<option>Argentina</option>
<option>Colombia</option>
<option>Chile</option>


<option>South Africa</option>
<option>Nigeria</option>
<option>Kenya</option>
<option>Ghana</option>


<option>Australia</option>
<option>New Zealand</option>


<option>Other</option>


</select>





<input class="input" type="date">





<select class="input">

<option>Select gender</option>

<option>Male</option>

<option>Female</option>

<option>Other</option>

</select>






<div class="interest-title">

Choose your interests (optional)

</div>





<div class="interests">


<label class="interest">
<input type="checkbox">
#Action
</label>


<label class="interest">
<input type="checkbox">
#Movies
</label>


<label class="interest">
<input type="checkbox">
#Sport
</label>


<label class="interest">
<input type="checkbox">
#Gaming
</label>


<label class="interest">
<input type="checkbox">
#Music
</label>


<label class="interest">
<input type="checkbox">
#Anime
</label>


<label class="interest">
<input type="checkbox">
#Technology
</label>


<label class="interest">
<input type="checkbox">
#Travel
</label>


</div>






<button>
Join Community
</button>






<div class="login">

Already a member?

 <a href="{{ route('login') }}">
Sign In
</a>

</div>



</div>






<div class="footer">

© 2026 TMK 4H Community. All rights reserved.

</div>



</body>

</html>