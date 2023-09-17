// Validate form  inputs before submitting data
function validateForm(){
  var name = document.getElementById("name").value;
  var age = document.getElementById("age").value;
  var address = document.getElementById("address").value;
  var email = document.getElementById("email").value;

   if(name == ""){
    alert("Name  is required");
    return false;
   }

   if(age == ""){
    alert("Age is required");
    return false;
   }

   else if(age <  10){
    alert("Age must be zero or less than zero");
    return false;
   }

   if(address == ""){
    alert("Address is required");
    return false;
   }

   if(email == ""){
    alert("Email is required");
    return false;
   }

   else if (!email.includes("@")){
     alert("Invalid email address");
     return  false;
   }

   return true;
}


// function to show Data
function showData(){
  var peopleList;
  if(localStorage.getItem("pepleList") == null){
    peopleList  = [];
  }

  else{
    peopleList  = JSON.parse(localStorage.getItem("peopleList"));
  }

  var html = "";

  peopleList.forEach(function (element, index){
   html += "<tr>";
   html += "<tr>" + element.name + "</td>";
   html += "<tr>" + element.name + "</td>";
   html += "<tr>" + element.name + "</td>";
   html += "<tr>" + element.name + "</td>";
   html += 
      '<td><button onclick="deleteData('+
        index +
        ')" class="btn btn-danger">Delete</button><button onclick="updateData('+
        index + 
       ')" class="btn btn-warning m-2">Edit</button>';
      html +="</tr>";
  });

  document.querySelector("#crudTable  tbody").innerHTML =
  html;
}

//  Loads All data when document or page loaded
document.onload = showData();

// function to add data

function AddData(){
  //if from is validate 
  if(validateForm() == true){
    var name = document.getElementById("name").value;
    var age = document.getElementById("age").value;
    var address = document.getElementById("address").value;
    var email = document.getElementById("email").value;

    var peopleList;
  if(localStorage.getItem("pepleList") == null){
    peopleList  = [];
  }

  else{
    peopleList  = JSON.parse(localStorage.getItem("peopleList"));
  }

  peopleList.push({
    name : name,
    age  : age,
    address : address,
    email : email,
  })

 localStorage.setItem("peopleList", JSON.stringify 
 (peopleList)); 
 showData();
 document.getElementById("name").value = "";
 document.getElementById("age").value = "";
 document.getElementById("address").value = "";
 document.getElementById("email").value = "";
 }
}
