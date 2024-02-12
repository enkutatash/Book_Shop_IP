function spin() {
        spinButton.disabled = true;
        var categories = document.getElementsByClassName("category");
        var randomIndex = Math.floor(Math.random() * categories.length);
        var chosenCategory = categories[randomIndex];

        var wheel = document.getElementById("wheel");
        wheel.classList.add("spin");

        setTimeout(function () {
          wheel.classList.remove("spin");
          for (var i = 0; i < categories.length; i++) {
            categories[i].style.opacity = "0";
          }

          setTimeout(function () {
            chosenCategory.style.opacity = "1";
          }, 500);
        }, 3000);
        spinButton.disabled = false;
      }
      let editForm = document.getElementById("editForm");
      editForm.addEventListener("submit", editCategories);
      function editCategories(event) {
        event.preventDefault();
        let inputcat1 = document.getElementById("category1");
        let inputcat2 = document.getElementById("category2");
        let inputcat3 = document.getElementById("category3");
        let inputcat4 = document.getElementById("category4");
        let inputcat5 = document.getElementById("category5");
        let inputcat6 = document.getElementById("category6");
        let cat1 = document.getElementById("cat1");
        let cat2 = document.getElementById("cat2");
        let cat3 = document.getElementById("cat3");
        let cat4 = document.getElementById("cat4");
        let cat5 = document.getElementById("cat5");
        let cat6 = document.getElementById("cat6");
        cat1.innerHTML = inputcat1.value;
        cat2.innerHTML = inputcat2.value;
        cat3.innerHTML = inputcat3.value;
        cat4.innerHTML = inputcat4.value;
        cat5.innerHTML = inputcat5.value;
        cat6.innerHTML = inputcat6.value;
        console.log(inputcat1.value);
      }