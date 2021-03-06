
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>

    <title>Plaeddit</title>

    <style type="text/css">
      body { font-size: 80%; font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif; }
      ul#tabs { list-style-type: none; margin: 30px 0 0 0; padding: 0 0 0.3em 0; }
      ul#tabs li { display: inline; }
      ul#tabs li a { color: #42454a; background-color: #dedbde; border: 1px solid #c9c3ba; border-bottom: none; padding: 0.3em; text-decoration: none; }
      ul#tabs li a:hover { background-color: #f1f0ee; }
      ul#tabs li a.selected { color: #000; background-color: #f1f0ee; font-weight: bold; padding: 0.7em 0.3em 0.38em 0.3em; }
      div.tabContent { border: 1px solid #c9c3ba; padding: 0.5em; background-color: #f1f0ee; }
      div.tabContent.hide { display: none; }
    </style>

    <script type="text/javascript">

    var tabLinks = new Array();
    var contentDivs = new Array();

    function init() {

      var tabListItems = document.getElementById('tabs').childNodes;
      for ( var i = 0; i < tabListItems.length; i++ ) {
        if ( tabListItems[i].nodeName == "LI" ) {
          var tabLink = getFirstChildWithTagName( tabListItems[i], 'A' );
          var id = getHash( tabLink.getAttribute('href') );
          tabLinks[id] = tabLink;
          contentDivs[id] = document.getElementById( id );
        }
      }

      var i = 0;

      for ( var id in tabLinks ) {
        tabLinks[id].onclick = showTab;
        tabLinks[id].onfocus = function() { this.blur() };
        if ( i == 0 ) tabLinks[id].className = 'selected';
        i++;
      }

      var i = 0;
      for ( var id in contentDivs ) {
        if ( i != 0 ) contentDivs[id].className = 'tabContent hide';
        i++;
      }
    }

    function showTab() {
      var selectedId = getHash( this.getAttribute('href') );

      for ( var id in contentDivs ) {
        if ( id == selectedId ) {
          tabLinks[id].className = 'selected';
          contentDivs[id].className = 'tabContent';
        } else {
          tabLinks[id].className = '';
          contentDivs[id].className = 'tabContent hide';
        }
      }
      return false;
    }

    function getFirstChildWithTagName( element, tagName ) {
      for ( var i = 0; i < element.childNodes.length; i++ ) {
        if ( element.childNodes[i].nodeName == tagName ) return element.childNodes[i];
      }
    }

    function getHash( url ) {
      var hashPos = url.lastIndexOf ( '#' );
      return url.substring( hashPos + 1 );
    }

    </script>
  </head>
  <body onload="init()">
    <h1>Plaeddit</h1>

    <ul id="tabs">
      <li><a href="#about">About the Project</a></li>
      <li><a href="#status">Plant Status</a></li>
      <li><a href="#Reddit">Reddit Activity</a></li>
      <li><a href="#team">Meet the Team</a></li>
    </ul>

    <div class="tabContent" id="about">
      <h2>About the Project</h2>
      <div>
        <p>This project consists of creating an autonomous watering and
          sunlight system to allow a plant to be controlled through social
          media interactions on Reddit. This system consists of
          light, temperature, and moisture sensors as well as a water pump and
          UV light. The water pump and UV light can be controlled through
          crowdsourced data from social media interactions from Twitter
          and/or Reddit. This website displays the current conditions of the
          plant so that social media users can make an informed decision about
          watering the plant or giving the plant light.</p>
          <br>
          <p>To get in on the action, first view the current conditions of the
            plant on the "Plant Status" tab. Once you are an informed user,
            head to the "Reddit Activity" tab to comment on the latest post.</p>
      </div>
    </div>

    <div class="tabContent" id="status">
      <h2>Plant Status</h2>
      <div>
        <?php
        $servername = "den1.mysql5.gear.host";
        $username = "plantdata1";
        $password = "BestProject!"; // need to fill in with real PW
        $dbname = "plantdata1";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM   plantdata1.plaeddit_data ORDER  BY dateofcare DESC LIMIT  1;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<p id='temperature'>Temperature: " . $row["temperature"] . " degrees Farenheit</p>"
                . "<p id='humidity'>Humidity: " . $row["humidity"] . "%</p>"
                . "<p id='moisture'>Moisture: " . $row["moisture"] . "%</p>"
                . "<p id='time'>Update time: " . $row["dateofcare"] . " MST</p>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
      </div>
    </div>

    <div class="tabContent" id="team">
      <h2>Meet the Team</h2>
      <div>
        <h3>Dominick</h3>
        <p>Dominick is a senior computer engineering major from Dallas, Texas.
        In his free time, he enjoys being outdoors and spending time with
        friends. </p><br>
        <h3>Hayley</h3>
        <p>Hayley is a senior computer engineering major from Dallas, Texas.
        In her free time, Hayley enjoys drinking coffee and playing golf. </p><br>
        <h3>Bill</h3>
        <p>Bill is a senior computer engineering major from Murphy, Texas.
        In his free time, Bill enjoys playing basketball and trying new food. </p><br>
      </div>
    </div>
  <div class = "tabContent" id="Reddit">
    <h2>Check out the Reddit!</h2>
    <script src='https://redditjs.com/subreddit.js' data-subreddit='Plaeddit'  ></script>
  </div>
  </body>
</html>
