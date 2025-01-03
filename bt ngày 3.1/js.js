const btn = document.querySelector(".btn");

function giaiPhuongTrinh() {
  const a = parseFloat(document.getElementById("a").value);
  const b = parseFloat(document.getElementById("b").value);
  const c = parseFloat(document.getElementById("c").value);

  if (isNaN(a) || isNaN(b) || isNaN(c)) {
    document.getElementById("ketqua").innerText =
      "Vui lòng nhập đầy đủ và hợp lệ các giá trị a, b, c!";
    return;
  }

  if (a === 0) {
    if (b === 0) {
      document.getElementById("ketqua").innerText =
        c === 0 ? "Phương trình vô số nghiệm." : "Phương trình vô nghiệm.";
    } else {
      let x = -c / b;
      document.getElementById(
        "ketqua"
      ).innerText = `Phương trình bậc 1: x = ${x}`;
    }
    return;
  }

  let delta = b * b - 4 * a * c;

  if (delta > 0) {
    let x1 = (-b + Math.sqrt(delta)) / (2 * a);
    let x2 = (-b - Math.sqrt(delta)) / (2 * a);
    document.getElementById(
      "ketqua"
    ).innerText = `Phương trình có hai nghiệm phân biệt: x1 = ${x1}, x2 = ${x2}`;
  } else if (delta === 0) {
    let x = -b / (2 * a);
    document.getElementById(
      "ketqua"
    ).innerText = `Phương trình có nghiệm kép: x = ${x}`;
  } else {
    document.getElementById("ketqua").innerText =
      "Phương trình vô nghiệm (delta < 0).";
  }
}

btn.addEventListener("click", giaiPhuongTrinh);