// seletores
const form = document.querySelector("form");
const nomeInput = document.querySelector("#nome");
const descricaoInput = document.querySelector("#descricao");
const valorInput = document.querySelector("#valor");
const fotoInput = document.querySelector("#foto");
const produtosContainer = document.querySelector("#produtos-container");

// funções
const adicionarProduto = (nome, descricao, valor, foto = undefined) => {
  const dados = new FormData();
  dados.append("nome", nome);
  dados.append("descricao", descricao);
  dados.append("valor", valor);

  if (foto !== undefined) dados.append("url_imagem", foto);

  fetch("http://localhost:8000/api/produtos", {
    method: "post",
    body: dados
  })
    .then(resposta => resposta.json())
    .then(mensagem => console.log(mensagem));
};

const mostrarProdutos = elementoHTML => {
  fetch("http://localhost:8000/api/produtos")
    .then(resposta => resposta.json())
    .then(produtos => {
      let html = "";
      produtos.forEach(produto => {
        html += `
          <div class="col-12 col-md-4 my-1">
            <div class="card border d-table w-100 h-100">
              <img class="card-img-top h-50" src="${produto.url_imagem}" alt="Card image cap" />
              <div class="card-body p-2 border-top">
                  <h5 class="card-title text-center">${produto.nome}</h5>
                  <p class="card-text text-center">${produto.descricao}</p>
                  <a href="#" class="btn btn-secondary col-12">Comprar por R$ ${produto.valor}</a>
              </div>
            </div>
          </div>
        `;
      });
      elementoHTML.innerHTML = html;
    });
};

const manipularForm = evento => {
  evento.preventDefault();

  adicionarProduto(
    nomeInput.value,
    descricaoInput.value,
    valorInput.value,
    fotoInput.files[0]
  );

  nomeInput.value = "";
  descricaoInput.value = "";
  valorInput.value = "";
  fotoInput.value = "";

  setTimeout(() => {
    mostrarProdutos(produtosContainer);
  }, 100);
};

// eventos
mostrarProdutos(produtosContainer);
form.onsubmit = manipularForm;
