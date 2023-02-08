const elements = document.querySelectorAll(".class");
const parent = document.querySelector(".parent");

const sortedElements = Array.from(elements).sort((a, b) => {
  return b.offsetHeight - a.offsetHeight;
});

sortedElements.forEach((element) => parent.appendChild(element));
