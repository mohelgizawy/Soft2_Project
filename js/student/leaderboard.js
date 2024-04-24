
const filter = {
  doctors: document.querySelector(".filter .doctors"),
  engineers: document.querySelector(".filter .engineers"),
};
let teacherType = "doctor";
const filerRate = (del) => {
  const rates = document.querySelectorAll(".rate > .global-row");
  rates.forEach((rate) => {
    rate.style.display = rate.classList.contains(del) ? "none" : "block";
  });
};
filerRate("engineer");
filter.doctors.onclick = (event) => {
  event.preventDefault();
  filter.engineers.classList.remove("active");
  filter.doctors.classList.add("active");
  filerRate("engineer");
  teacherType = "doctor";
};
filter.engineers.onclick = (event) => {
  event.preventDefault();
  filter.doctors.classList.remove("active");
  filter.engineers.classList.add("active");
  filerRate("doctor");
  teacherType = "engineer";
};
const votes = document.querySelectorAll(".Add-votes");
const setTeacher = (name) => {
  document.querySelector(`input[name="teacherName"]`).value = name;
  document.querySelector(`input[name="teacherType"]`).value = teacherType;
};
votes.forEach((vote) => {
  vote.onclick = (event) => {
    event.preventDefault();
    document.querySelector(".overlay-comment").style.display = "flex";
    console.log(vote.previousSibling.previousSibling.lastChild.previousSibling.firstChild.nextSibling.textContent)
    const teacherName = vote.previousSibling.previousSibling.lastChild.previousSibling.firstChild.nextSibling.textContent;
    setTeacher(teacherName);
  };
});
const closeVote = document.querySelector("i.fa-xmark");
closeVote.onclick = (event) => {
  event.preventDefault();
  document.querySelector(".overlay-comment").style.display = "none";
  setTeacher("");
};
const stars = document.querySelectorAll(".star i");
const setRate = (rate) => {
  document.querySelector(`input[name="rate"]`).value = rate;
};
const addStar = (index) => {
  stars.forEach((star, key) => {
    if (index >= key) {
      star.classList.remove("far");
      star.classList.add("fas");
    } else {
      star.classList.remove("fas");
      star.classList.add("far");
    }
  });
};
const removeStar = () => {
  stars.forEach((star, key) => {
    star.classList.remove("fas");
    star.classList.add("far");
  });
};
let isStarClicked = false;
stars.forEach((star, index) => {
  star.onclick = (event) => {
    event.preventDefault();
    addStar(index);
    isStarClicked = true;
    setRate(index + 1);
  };
  star.onmouseenter = (event) => {
    event.preventDefault();
    addStar(index);
    isStarClicked = false;
    setRate(index + 1);
  };
  star.onmouseleave = (event) => {
    event.preventDefault();
    if (!isStarClicked) {
      removeStar(index);
      setRate(0);
    }
  };
});
