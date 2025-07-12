function openModal(imageSrc, title, description) {
    document.getElementById('modal-image').src = imageSrc;
    document.getElementById('modal-title').innerText = title;
    document.getElementById('modal-description').innerText = description;
    document.getElementById('image-modal').style.display = "flex";

    const modalContent = document.querySelector('.modal-content');
    modalContent.scrollTop = 0;
}

window.addEventListener('load', function() {
    setTimeout(function() {
        alert('Bem-vindo ao website!');
    }, 5000);
});

function closeModal() {
    document.getElementById('image-modal').style.display = "none";
}

function loadContent(page) {
    $("#content").load(page, function (response, status) {
        if (status === "error") {
            alert("Erro ao carregar a página: " + page);
        }
    });
}

function calculateBudget() {
    let pagePrice = parseInt(document.getElementById("page-type").value);
    let months = parseInt(document.getElementById("deadline").value) || 0;
    let extraTabs = parseInt(document.getElementById("extra-tabs").value) || 0;
    let totalExtraTabs = extraTabs * 400;
    let discount = Math.min(0.2, months * 0.05);
    let total = (pagePrice + totalExtraTabs) * (1 - discount);
    document.getElementById("total-price").innerText = total.toFixed(2) + "€";
}

function calcularOrcamento() {
    let tipoPagina = document.getElementById("tipo_pagina").value;
    let prazo = parseInt(document.getElementById("prazo").value);

    if (!tipoPagina) {
        document.getElementById("orcamento-total").textContent = "0€";
        return;
    }

    let precoBase = parseFloat(tipoPagina);
    let desconto = 0;

    let extrasSeparadores = 0;
    let checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    extrasSeparadores = checkboxes.length * 400;

    precoBase += extrasSeparadores;

    if (prazo === 1) {
        desconto = 20;
    } else if (prazo === 2) {
        desconto = 15;
    } else if (prazo === 3) {
        desconto = 10;
    } else if (prazo >= 4) {
        desconto = 5;
    }

    let precoFinal = precoBase - (precoBase * (desconto / 100));
    document.getElementById("orcamento-total").textContent = precoFinal.toFixed(2) + "€";
}

let map, directionsService, directionsRenderer;

function initMap() {
    const officeLocation = { lat: 38.7169, lng: -9.1399 };

    map = new google.maps.Map(document.getElementById("map"), {
        center: officeLocation,
        zoom: 14,
    });

    new google.maps.Marker({
        position: officeLocation,
        map: map,
        title: "Nosso Escritório",
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);
}

function getRoute() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            };

            const request = {
                origin: userLocation,
                destination: { lat: 40.221828, lng: -8.435255 },
                travelMode: google.maps.TravelMode.DRIVING,
            };

            directionsService.route(request, (result, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(result);
                    document.getElementById("route-info").innerText =
                        `Distância: ${result.routes[0].legs[0].distance.text} | Tempo estimado: ${result.routes[0].legs[0].duration.text}`;
                } else {
                    alert("Não foi possível calcular a rota.");
                }
            });
        });
    } else {
        alert("Geolocalização não suportada pelo navegador.");
    }
}

function validarFormulario() {
    const nome = document.getElementById("nome").value;
    const apelido = document.getElementById("apelido").value;
    const telefone = document.getElementById("telefone").value;
    const email = document.getElementById("email").value;
    const data = document.getElementById("data").value;
    const motivo = document.getElementById("motivo").value;

    console.log("Nome:", nome);
    console.log("Apelido:", apelido);
    console.log("Telefone:", telefone);
    console.log("Email:", email);
    console.log("Data:", data);
    console.log("Motivo:", motivo);

    if (!nome || !apelido || !telefone || !email || !data || !motivo) {
        alert("Por favor, preencha todos os campos!");
        return false;
    }

    const regexTelefone = /^[0-9]{9}$/;
    if (!regexTelefone.test(telefone)) {
        alert("Por favor, insira um número de telefone válido (9 dígitos).");
        return false;
    }

    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!regexEmail.test(email)) {
        alert("Por favor, insira um e-mail válido.");
        return false;
    }

    alert("Formulário enviado com sucesso!");
    return true;
}
