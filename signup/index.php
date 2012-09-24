<!doctype html>
<html>
    <head>
        <title>Mipi Signup</title>
        <style>
            #fbid, #fbpre {
                font-family: sans-serif;
                font-size: 10pt;
                border: solid 1px #AAA;
                padding: 1px 0;
            }
            #fbpre {
                border-right: none;
                padding-right: 0;
                padding-left: 1px;
            }
            #fbid {
                border-left: none;
                margin-left: 0;
                width: 100px;
            }
        </style>
    </head>
    <body>
        <h1>Signup for Mipi</h1>
        <form enctype="multipart/form-data" method="post">
            <fieldset>
                <legend>Account</legend>
                <label>Username: <input type="text" name="username" /></label> (should be the same as your WPI username)<br />
                <label>Password: <input type="password" name="password" /></label><br />
            </fieldset>
            <fieldset>
                <legend>Basic Info</legend>
                <label>First Name: <input type="text" name="name_f" /></label><br />
                <label>Last Name: <input type="text" name="name_l" /></label><br />
                <label>Pi Number: &pi;<input type="number" name="pi"/></label><br />
                <label>Year of Graduation: <input type="number" name="yog" min="1913" max="<?php echo date('Y')+4 ?>" value="<?php echo date('Y') ?>" /></label><br />
                <label>Date of Birth: <input type="date" name="dob" /></label><br />
                <label>Major: <input type="text" name="major" /></label>
            </fieldset>
            <fieldset>
                <legend>Contact Info</legend>
                <label>Email <input type="email" name="email" /></label><br />
                <label>Cell Phone: <input type="text" name="phone" /></label><br />
                <label>School Address: <input name="schoolloc" type="text" value="30 Dean St" /> 
        (ex. Morgan 412, 85 Salisbury Street)</label><br />
                <label>Home Address:<br /><textarea name="homeaddr"></textarea></label><br />
            </fieldset>
            <fieldset>
                <legend>Social</legend>
                <label>Facebook Username: <span id="fbpre">www.facebook.com/</span><input name="fbid" id="fbid" onchange="document.getElementById('fbpic').style.background = 'url(http://graph.facebook.com/'+ this.value +'/picture)';" /></label>
                <div id="fbpic" style="height: 50px;width: 50px;display:inline-block;vertical-align: bottom;background:gray;">&nbsp;</div><br />
                <label>Twitter Name: @<input name="twitid" id="twitid" onchange="document.getElementById('twitpic').style.background = 'url(https://api.twitter.com/1/users/profile_image?screen_name='+ this.value +')';" /></label>
                <div id="twitpic" style="height:48px;width:48px;display:inline-block;vertical-align: bottom;background:gray;">&nbsp;</div><br />

            </fieldset>
            <fieldset>
                <legend>Photo</legend>
                <input type="file" name="photo" accept="image/jpg" /><br />
                Please upload a photo of yourself for your profile picture
            </fieldset>
        </form>
    </body>
</html>