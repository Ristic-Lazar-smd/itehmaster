
// TOGGLE ZA PRIKAZIVANJE, LEGACY CODE
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
      //$('#izmeniForm').reset;
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

    console.log(response);
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
  //$inputs.prop("disabled", true);

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
  //$inputs.prop("disabled", true); 

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
  console.log(obj);

  $.get("handler/getLastElement.php", function ( data ) {
    var php_var = data;
    console.log("ove pise php_vat"+php_var);
    console.log(data);
    console.log($("#tabela tbody tr:last").get());
    $("#tabela tbody").append(`
      <tr>
          <td>${data}</td>
          <td>${obj.nazivKnjiga}</td>
          <td>${obj.pisac}</td>
          <td>${obj.godinaPisanja}</td>
          <td>${obj.zanr}</td>
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
  console.log(obj);
  console.log(obj.knjigaID);
  console.log($(`#tabela tbody #tr-${obj.knjigaID} td`).get());
  let tds = $(`#tabela tbody #tr-${obj.knjigaID} td`).get();
  tds[1].textContent = obj.nazivKnjiga;
  tds[2].textContent = obj.pisac;
  tds[3].textContent = obj.godinaPisanja;
  tds[4].textContent = obj.zanr;
}
