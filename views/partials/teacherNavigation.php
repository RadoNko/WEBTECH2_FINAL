<?php
if (session_status() != 2){
    session_start();
}
?>
<header class="h-screen col-span-2 bg-gray-600 flex flex-col justify-between sticky top-0 shadow-2xl">
    <div class="flex-col">
        <div class="flex flex-row items-center w-full logoColourBackground p-4">
            <div>
                <p class="text-white">Logged In:</p>
                <p class="text-white"><?php echo $_SESSION["username"]; ?></p>
            </div>
        </div>
        <div id="myDIV" class="px-6 pt-4 pb-8">
            <a href="/Final/views/examOverview.php" class="block px-2 py-1 text-white font-semibold rounded hover:bg-gray-500">Exam Overview</a>
            <a href="/Final/views/formula-sheet.php" class="block px-2 py-1 mt-1 text-white font-semibold rounded hover:bg-gray-500">Formula sheets</a>
            <?php
            if (isset($_SESSION) && isset($_SESSION["exam_id"]) && $_SESSION["exam_id"] > 0){
                require_once "../controllers/ExamController.php";
                $examController = new ExamController();
                $testName = $examController->getExamName($_SESSION["exam_id"])["name"];
                echo "<a href='/Final/views/createTest.php' class='block px-2 py-1 mt-1 text-white font-semibold rounded opacity-50'>Create {$testName} </a>";
            }
            ?>

            <a href="/Final/views/fillTest.php" class="block px-2 py-1 mt-1 text-white font-semibold rounded opacity-50">Debug Page Render Test</a>
            <a href="/Final/views/rateTest.php" class="block px-2 py-1 mt-1 text-white font-semibold rounded opacity-50">Debug Page Rate Test</a>

        </div>
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

