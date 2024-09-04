const student_id = document.getElementById("student___add");
const name = document.getElementById("name");
const description = document.getElementById("description");
let student__list = document.getElementById("student__list");

function add_student() {
    let name = document.getElementById("name").value;
    let prenom = document.getElementById("prenom").value;

if (name === "" ||  prenom === ""){
    window.alert("please fill in your name and your first name")
    }

let li = document.createElement("li")
li.innerHTML = name + prenom ;

let editButton = document.createElement("button");
   editButton.innerHTML = "<ion-icon name=\"pencil-outline\"></ion-icon>"

editButton.onclick = function () {
    
}
    
    
let delButton = document.createElement("button");
   delButton.innerHTML = "<ion-icon name=\"trash-outline\"></ion-icon>"
    
delButton.onclick = function () {
    del_student(li);
}

li.appendChild(editButton);
li.appendChild(delButton)

student__list.appendChild(li);

}



function add_description() {
    
}



