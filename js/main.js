// TOGGLE ZA PRIKAZIVANJE
function prikazi() {
  var x = document.getElementById("pregled");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

// BRISANJE
$("#btn-izbrisi").click(function () {
  const checked = $("input[type=radio]:checked");
  request = $.ajax({
    url: "handler/delete1.php",
    type: "post",
    data: { knjigaID: checked.val() },
  });
  request.done(function (response, textStatus, jqXHR) {
    if (response === "Success") {
      checked.closest("tr").remove();
      console.log("Knjiga je obrisana ");
      alert("Knjiga je obrisana");
    } else {
      console.log("Knjiga nije obrisana " + response);
      alert("Knjiga nije obrisan");
    }
  });
});

// IZMENA
$("#btn-izmeni").click(function () {
  const checked = $("input[name=checked-donut]:checked");

  request = $.ajax({
    url: "handler/get1.php",
    type: "post",
    data: { knjigaID: checked.val() },
    dataType: "json",
  });

  request.done(function (response, textStatus, jqXHR) {
    console.log("Popunjena");
    $("#nazivv").val(response[0]["nazivKnjiga"]);
    $("#pisacc").val(response[0]["pisac"].trim());
    $("#godinaa").val(response[0]["godinaPisanja"].trim());
    $("#zanrr").val(response[0]["zanr"].trim());
    $("#idd").val(checked.val());

  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("The following error occurred: " + textStatus, errorThrown);
  });
});

$("#izmeniForm").submit(function () {
  event.preventDefault();
  console.log("Izmena");
  const $form = $(this);
  const $inputs = $form.find("input, select, button");
  const serializedData = $form.serialize();
  console.log(serializedData);
  let obj = $form.serializeArray().reduce(function (json, { name, value }) {
    json[name] = value;
    return json;
  }, {});
  console.log(obj);

  request = $.ajax({
    url: "handler/update1.php",
    type: "post",
    data: serializedData,
  });

  request.done(function (response, textStatus, jqXHR) {
    if (response === "Success") {
      console.log("Knjiga je izmenjena");
      updateRow(obj);
    } else console.log("Knjiga nije izmenjen " + response);
    console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("The following error occurred: " + textStatus, errorThrown);
  });
});

$("#btnDodaj").submit(function () {
  $("myModal").modal("toggle");
  return false;
});

$("#btn-izmeni").submit(function () {
  $("#myModal").modal("toggle");
  return false;
});

// DODAVANJE
$("#dodajForm").submit(function () {
  event.preventDefault();

  const $form = $(this);
  const $inputs = $form.find("input, select, button");
  const serializedData = $form.serialize();
  console.log(serializedData);
  let obj = $form.serializeArray().reduce(function (json, { name, value }) {
    json[name] = value;
    return json;
  }, {});
  console.log(obj);

  request = $.ajax({
    url: "handler/add1.php",
    type: "post",
    data: serializedData,
  });

  request.done(function (response, textStatus, jqXHR) {
    if (response === "Success") {
      alert("Knjiga je dodata");
      appandRow(obj);
    } else console.log("Knjiga nije dodat " + response);
    console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("The following error occurred: " + textStatus, errorThrown);
  });
});

function appandRow(obj) {
  //jako gadno ali jbg
  switch (obj.zanr) {
    case "1": 
      $test = "Naučna fantastika"; 
      break;
    case "2":
      $test = "Triler"; 
      break;
    case "3": 
    $test = "Fantastika"; 
      break;
    case "4": 
    $test = "Horor"; 
  }
  $.get("handler/getLastElement.php", function ( data ) {
    var php_var = data;
    $("#tabela tbody").append(`
      <tr>
          <td>${data}</td>
          <td>${obj.nazivKnjiga}</td>
          <td>${obj.pisac}</td>
          <td>${obj.godinaPisanja}</td>
          <td>${$test}</td>
          <td>
              <label class="custom-radio-btn">
                  <input type="radio" name="checked-donut" value=${data}>
                  <span class="checkmark"></span>
              </label>
          </td>
      </tr>
    `);
  });
}

function updateRow(obj) {
  let tds = $(`#tabela tbody #tr-${obj.knjigaID} td`).get();
  tds[1].textContent = obj.nazivKnjiga;
  tds[2].textContent = obj.pisac;
  tds[3].textContent = obj.godinaPisanja;

  switch (obj.zanr) {
    case "1": 
      tds[4].textContent = "Naučna fantastika"; 
      break;
    case "2":
      tds[4].textContent = "Triler"; 
      break;
    case "3": 
      tds[4].textContent = "Fantastika"; 
      break;
    case "4": 
      tds[4].textContent = "Horor"; 
  }
}
