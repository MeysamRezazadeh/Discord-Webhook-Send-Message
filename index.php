<!-- https://github.com/MeysamRezazadeh  -->
<?php

// PUT YOUR BOT TOKEN HERE
$TOKEN = "";

// PUT YOUR SERVER ID HERE
$SERVER_ID = '';

$urls = [
    'roles',
    'members?limit=1000',
    'emojis',
];

$data= [];

foreach ($urls as $url) {
    $curl= curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $link = 'https://discord.com/api/guilds/'.$SERVER_ID.'/'.$url;
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bot $TOKEN",
            'Content-Type: application/json',
        )
    );
    $res = curl_exec($curl);
    curl_close($curl);
    array_push($data, json_decode($res));
}

$roles = $data[0];
$members = $data[1];
$emojis = $data[2];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Step Bros</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="https://cdn.discordapp.com/icons/<?php echo $SERVER_ID ?>/3f4c0ae796d9ecca380f1089a4d2f625.webp">

    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/moment-timezone-with-data-10-year-range.min.js"></script>

    <script>
        function addText(event) {
            var targ = event.target || event.srcElement;
            document.getElementById("alltext").value += targ.value || targ.value;
        }
    </script>

    <script type="text/javascript">
        $(function() {
            $('#SubmitForm').submit(function( event ) {
                $.ajax({
                    url: 'check.php',
                    type: 'POST',
                    dataType: 'html',
                    data: $('#SubmitForm').serialize(),
                    success: function(content)
                    {
                        $("#popout").html(content);
                    }
                });
                event.preventDefault();
            });
        });
    </script>

</head>

<body>
<div class="container">
    <h1>Send a message to StepBros discord server</h1>
<div id="popout"></div>

<div class="roles">
    <strong>Roles</strong>
    <hr>
    <?php foreach ($roles as $role) { ?>
        <button class="button" style="background-color:<?php echo "#".dechex((float) $role->color) ?>" type="submit" value="<@&<?php echo $role->id ?>>" onclick="addText(event)"><?php echo $role->name ?></button>
    <?php } ?>
</div>

<div class="members">
    <strong>Members</strong>
    <hr>
    <?php foreach ($members as $member) { ?>
        <button class="button" type="submit" value="<@<?php echo $member->user->id ?>>" onclick="addText(event)"><?php echo $member->user->username ?></button>
    <?php } ?>
</div>

<div class="emojis">
    <strong>Emojis</strong>
    <hr>
    <?php foreach ($emojis as $emoji) {
        if ($emoji->animated != true) { ?>
            <button style="background-image: url('https://cdn.discordapp.com/emojis/<?php echo $emoji->id ?>.webp')" class="emoji_button" type="submit" value='<:<?php echo $emoji->name ?>:<?php echo $emoji->id ?>>' onclick="addText(event)"></button>
        <?php } ?>
    <?php } ?>
</div>


    <div class="message">
    <strong>Message</strong>
    <hr>
    <form method="post" id="SubmitForm">


            <label for="alltext"></label>
            <textarea id="alltext" placeholder="Enter Message" name="message" required></textarea>

            <label for="password">
                <input type="password" placeholder="Enter Password" name="password" required>
            </label>
        <button type="submit" class="button-64" role="button"><span class="text">Send</span></button>

    </form>
</div>
</div>
</body>
