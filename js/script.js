const random = (
  start = Number.MIN_SAFE_INTEGER,
  end = Number.MAX_SAFE_INTEGER
) => {
  return Math.floor(Math.random() * (end - start) + start);
};
const range = (
  number,
  start = Number.MIN_SAFE_INTEGER,
  end = Number.MAX_SAFE_INTEGER
) => {
  // console.log({ number });
  // return end;
  if (number < start) return start;
  else if (number > end) return end;
  return number;
};

const findMore = document.querySelector("button.findMore");
findMore.onclick = () => {
  if (findMore.innerHTML.includes("Show more")) {
    document.querySelector(".more").style.display = "block";
    findMore.innerHTML = `Show less <span class="material-symbols-rounded">expand_less</span>`;
  } else {
    document.querySelector(".more").style.display = "none";
    findMore.innerHTML = `Show more <span class="material-symbols-rounded">expand_more</span>`;
  }
  console.log(findMore);
};

// sliders
const allSliders = document.querySelectorAll(".slider");
for (let one of allSliders) {
  let show = 4,
    postion = 0;
  const check = (left = one.children[1].scrollLeft) => {
    console.log(left);
    if (left <= 20) one.children[0].style.opacity = 0.2;
    else one.children[0].style.opacity = 1;

    if (left >= one.children[1].scrollWidth - (show - 1) * 340)
      one.children[2].style.opacity = 0.2;
    else one.children[2].style.opacity = 1;
  };
  check();
  one.children[0].onclick = () => {
    one.children[1].scrollLeft -= 340;
    check(one.children[1].scrollLeft - 340);
  };
  one.children[2].onclick = () => {
    one.children[1].scrollLeft += 340;
    check(one.children[1].scrollLeft + 340);
  };
}

// advance animtion
const custom = (n) => {
  const emoji = document.querySelector(
    ".advanceAnimtion .components .emoji .face"
  );
  const { width } = emoji.getBoundingClientRect();
  return (width * n) / 200;
};
const componentsImg = document.querySelectorAll(
  `.advanceAnimtion .components div[class^="component"] img`
);
componentsImg.forEach((component, index) => {
  component.style.left =
    (index % 2 ? random(500, 900) : random(-500, -900)) + "%";
  component.style.top =
    (index % 2 ? random(200, 600) : random(-200, -600)) + "%";
});
const components = {
  list: [
    ...document.querySelectorAll(
      `.advanceAnimtion .components div[class^="component"] img`
    ),
  ],
  state: "out",
};
const pupils = document.querySelectorAll(
  ".advanceAnimtion .components .emoji .eye .pupil"
);
const mouse = document.querySelector(
  ".advanceAnimtion .components .emoji .mouse"
);
let focusIn;
setInterval(() => {
  if (components.state == "out") {
    const index = random(0, components.list.length);
    focusIn = components.list[index];
    components.list[index].classList.add("setted");
    components.list.splice(index, 1);
    if (!components.list.length) {
      components.state = "in";
      components.list = [
        ...document.querySelectorAll(
          `.advanceAnimtion .components div[class^="component"] img`
        ),
      ];
    }
  } else {
    const index = random(0, components.list.length);
    focusIn = components.list[index];
    components.list[index].classList.remove("setted");
    components.list.splice(index, 1);
    if (!components.list.length) {
      components.state = "out";
      components.list = [
        ...document.querySelectorAll(
          `.advanceAnimtion .components div[class^="component"] img`
        ),
      ];
    }
  }
}, 3000);
const move = (pupil, top, left) => {
  const { top: pupilTop, left: pupilLeft } = pupil.getBoundingClientRect();
  pupil.style.top = custom(range(top - pupilTop, -5, 35)) + "px";
  pupil.style.left = custom(range(left - pupilLeft, -5, 35)) + "px";
};
setInterval(() => {
  if (focusIn) {
    let { top, left, width, height } = focusIn.getBoundingClientRect();
    const { top: parentTop, left: parentLeft } =
      focusIn.parentNode.getBoundingClientRect();
    if (top == parentTop && left == parentLeft) mouse.classList.add("smile");
    else mouse.classList.remove("smile");
    pupils.forEach((pupil, index) =>
      move(pupil, top + height / 2, left + width / 2 + custom(index % 2 ? 35 : -35))
    );
  }
}, 100);
