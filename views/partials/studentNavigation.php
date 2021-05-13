<header class="h-screen col-span-2 bg-gray-600 flex flex-col justify-between sticky top-0 shadow-2xl">
  <div class="flex-col">
    <div class="flex flex-row items-center w-full logoColourBackground p-4">
      <div>
        <p class="text-white">Logged In:</p>
          <p class="text-white"><?php echo $_SESSION["logged_id"]; ?></p>
      </div>
    </div>
    <div id="myDIV" class="px-6 pt-4 pb-8">
      <a href="/Final/views/fillTest.php" class="block px-2 py-1 text-white font-semibold rounded hover:bg-gray-500">Show exam</a>
      <a href="/Final/views/formula-sheet.php" class="block px-2 py-1 mt-1 text-white font-semibold rounded hover:bg-gray-500">Formula sheets</a>
    </div>
  </div>
    <style>
        :root{
            --clr-neon: #17CF97;
        }
        #countdown{
            display: inline-block;
            color: var(--clr-neon);
            padding: 0.25em 1em;
            text-shadow: 0 0 0.125em hsl(0 0% 100% / 0.3), 0 0 0.45em currentColor;
            position: relative;
        }
        #countdown::before{
            content: attr(title);
            position: absolute;
            top: 100%;
            width: 100%;
            height: 100%;
            transform: perspective(1em) rotateX(180deg) scale(1, 0.75);
            filter: blur(0.1em);
            opacity: 0.7;
        }

    </style>
  <div class="grid ">
    <p title="00:00:00" id="countdown" class="font-bold text-4xl justify-self-center break-words">00:00:00</p>
  </div>
  <button onclick="logOut()" class="block px-2 py-1 mt-1 text-white font-semibold rounded hover:bg-gray-500 self-end">Logout</button>
</header>

<script>

  window.addEventListener('DOMContentLoaded', (event) => {
    const elements = document.getElementById('myDIV').childNodes
    for (const element of elements){
      if (window.location.href === element.href){
        if (element.href != null){
          element.className += " logoColourBackground";
          return
        }
      }
    }
  });

  function myFunction1() {
    let elements = document.getElementsByClassName("buttonImg")
    for(let element of elements){
      element.classList.toggle("hidden")
    }
  }
  function myFunction() {
    var element = document.getElementById("myDIV");
    element.classList.toggle("hidden");
  }
</script>
<script src="/Final/js/logOut.js"></script>

