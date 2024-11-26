<?php
  $finalURL;
  $error;
  $count = intval( file_get_contents('count.txt') );

  if ($_POST) {
    $url = trim($_POST['url']);
    if ( str_starts_with(strtolower($url), 'https://www.tiktok.com/') or str_starts_with(strtolower($url), 'https://tiktok.com/') ) {
      $finalURL = getFinalRedirectedURL($url);
      $finalURL = strtok($finalURL, '?');
      $count++;
      file_put_contents('count.txt', $count);
    } else {
      $error = "Not a TikTok link!";
    }
  }

  function getFinalRedirectedURL($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_exec($ch);
    $finalURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    return $finalURL;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>fixtok</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
      body {
        word-wrap: break-word;
      }

      #inputs-container {
        display: flex;
        width: 100%;
        gap: 10px;
      }

      .text-center {
        text-align: center;
      }

      .error {
        border-color: #ff0000;
      }

      #url {
        flex-grow: 2;
      }

      #header {
        display: flex;
        justify-content: space-between;
      }

      #header a {
        color: inherit;
      }
    </style>
  </head>
  <body>
    <div id="header">
      <h1>fixtok</h1>
      <h1>
        <a href="https://github.com/biffhuxtable/fixtok/" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" width="0.97em" height="1em" viewBox="0 0 496 512"><path fill="currentColor" d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6c-3.3.3-5.6-1.3-5.6-3.6c0-2 2.3-3.6 5.2-3.6c3-.3 5.6 1.3 5.6 3.6m-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9c2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3m44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9c.3 2 2.9 3.3 5.9 2.6c2.9-.7 4.9-2.6 4.6-4.6c-.3-1.9-3-3.2-5.9-2.9M244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2c12.8 2.3 17.3-5.6 17.3-12.1c0-6.2-.3-40.4-.3-61.4c0 0-70 15-84.7-29.8c0 0-11.4-29.1-27.8-36.6c0 0-22.9-15.7 1.6-15.4c0 0 24.9 2 38.6 25.8c21.9 38.6 58.6 27.5 72.9 20.9c2.3-16 8.8-27.1 16-33.7c-55.9-6.2-112.3-14.3-112.3-110.5c0-27.5 7.6-41.3 23.6-58.9c-2.6-6.5-11.1-33.3 2.6-67.9c20.9-6.5 69 27 69 27c20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27c13.7 34.7 5.2 61.4 2.6 67.9c16 17.7 25.8 31.5 25.8 58.9c0 96.5-58.9 104.2-114.8 110.5c9.2 7.9 17 22.9 17 46.4c0 33.7-.3 75.4-.3 83.6c0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252C496 113.3 383.5 8 244.8 8M97.2 352.9c-1.3 1-1 3.3.7 5.2c1.6 1.6 3.9 2.3 5.2 1c1.3-1 1-3.3-.7-5.2c-1.6-1.6-3.9-2.3-5.2-1m-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9c1.6 1 3.6.7 4.3-.7c.7-1.3-.3-2.9-2.3-3.9c-2-.6-3.6-.3-4.3.7m32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2c2.3 2.3 5.2 2.6 6.5 1c1.3-1.3.7-4.3-1.3-6.2c-2.2-2.3-5.2-2.6-6.5-1m-11.4-14.7c-1.6 1-1.6 3.6 0 5.9s4.3 3.3 5.6 2.3c1.6-1.3 1.6-3.9 0-6.2c-1.4-2.3-4-3.3-5.6-2"/></svg>
        </a>
      </h1>
    </div>
    <form method="post" action="/fixtok/index.php">
      <div id="inputs-container">
        <input type="text" name="url" id="url" placeholder="Enter a TikTok link..." required>
        <button type="submit" id="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M17.278 2.613a1 1 0 0 1 1.89.643l-.038.11l-2.61 6.42l.657.175c1.05.281 1.924 1.134 2.09 2.298c.142 1 .275 2.52.092 4.086c-.182 1.552-.69 3.278-1.947 4.546c-.462.466-1.125.54-1.573.548c-.511.008-1.1-.07-1.705-.19c-1.216-.242-2.674-.69-4.054-1.166l-.414-.145l-.813-.294l-.78-.291l-.734-.283l-.978-.388l-.822-.335l-.817-.345a1 1 0 0 1-.228-1.708c1.377-1.08 2.67-2.322 3.761-3.469l.529-.564l.25-.274l.472-.527l.22-.252l.594-.695l.337-.406a3.1 3.1 0 0 1 2.981-1.087l.199.046l.737.197zM10.5 13.348a44 44 0 0 1-3.479 3.444q.863.349 1.733.68a7.3 7.3 0 0 0 1.426-1.338a7 7 0 0 0 .488-.654l.142-.232a1 1 0 0 1 1.747.973c-.234.42-.527.814-.832 1.184a10 10 0 0 1-.792.856c.462.158.924.308 1.372.446c.373-.257.81-.785 1.206-1.385q.239-.36.452-.74l.204-.384a1 1 0 0 1 1.793.887c-.229.462-.496.909-.78 1.339a11 11 0 0 1-.634.868l.421.082c.362.067.744.114 1.089.043c.766-.815 1.163-1.998 1.316-3.305q.053-.456.068-.904zm2.819-2.35a1.09 1.09 0 0 0-1.116.378l-.243.293l5.398 1.446l-.047-.392l-.024-.182c-.037-.253-.216-.491-.511-.61l-.116-.038zM5.565 7.716l.064.14A3.26 3.26 0 0 0 6.866 9.22l.1.058a.068.068 0 0 1 0 .118l-.1.058A3.26 3.26 0 0 0 5.63 10.82l-.064.139a.071.071 0 0 1-.13 0l-.064-.14a3.26 3.26 0 0 0-1.237-1.364l-.1-.058a.068.068 0 0 1 0-.118l.1-.058A3.26 3.26 0 0 0 5.37 7.855l.064-.139a.071.071 0 0 1 .13 0Zm2.832-4.859c.04-.09.166-.09.206 0l.102.222a5.2 5.2 0 0 0 1.97 2.171l.157.093a.108.108 0 0 1 0 .189l-.158.092a5.2 5.2 0 0 0-1.97 2.172l-.1.222a.113.113 0 0 1-.207 0l-.102-.222a5.2 5.2 0 0 0-1.97-2.172l-.158-.092a.108.108 0 0 1 0-.189l.159-.093a5.2 5.2 0 0 0 1.97-2.171l.1-.222Z"/></g></svg>
        </button>
      </div>
    </form>
    <?php
      if ($finalURL) {
        echo '
        <p class="notice"><a id="final-url" href="' . $finalURL . '">' . $finalURL . '</a></p>
        <button type="button" id="btn-copy">
          Copy
        </button>
        <a class="button text-center" href="/fixtok">Reset</a>
        ';
      }

      if ($error) {
        echo '
          <p class="error notice">' . $error . '</p>
          <a class="button text-center" href="/fixtok">Reset</a>
        ';
      }
    ?>
    <blockquote id="facts">      
    </blockquote>
    <p class="text-center">
      <em><?php echo $count ?> TikTok links fixed</em>
    </p>
  </body>
  <script>
    if (document.getElementById('btn-copy')) {
      var btnCopy = document.getElementById('btn-copy');
      btnCopy.addEventListener('click', () => {
        var finalUrl = document.getElementById('final-url');
        const textToCopy = finalUrl.textContent;
        navigator.clipboard.writeText(textToCopy)
        .then(() => {
          console.log('Text copied to clipboard:', textToCopy);
        })
        .catch(err => {
          console.error('Failed to copy text:', err);
        });
      });
    }

    async function getFact() {
      var el = document.getElementById('facts');
      const url = "https://uselessfacts.jsph.pl/api/v2/facts/random";
      try {
        const response = await fetch(url);
        if (!response.ok) {
          throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        el.textContent = json.text;
      } catch (error) {
        console.error(error.message);
      }
    }

    getFact();
  </script>
</html>