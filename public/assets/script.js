// ***** switch siginin forms ********* //

const btn1 = document.getElementById("btn1");
const btn2 = document.getElementById("btn2");
const form1 = document.getElementById("form1");
const form2 = document.getElementById("form2");

form1.style.display = "block";
form2.style.display = "none";

btn1.onclick = () => {
    form1.style.display = "block";
    form2.style.display = "none";
};

btn2.onclick = () => {
    form1.style.display = "none";
    form2.style.display = "block";
};

// ************************************** //