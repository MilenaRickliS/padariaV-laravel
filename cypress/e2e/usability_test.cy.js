describe('Usability Tests for PadariaV Laravel', () => {
  
  beforeEach(() => {
    cy.visit('http://localhost:8000'); // Visita a página inicial
  });

  it('should load the menu page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // Clica no link para a página de cardápio
    cy.url().should('include', 'http://localhost:8000'); // Verifica se a URL está correta
    cy.get('h1').should('contain', 'Cardápio'); // Verifica se a página contém o título correto
  });

  it('should register a user', () => {
    cy.get('a[href="http://localhost:8000/register"]').click(); // Clica no link para a página de cadastro
    cy.url().should('include', 'http://localhost:8000/register'); // Verifica se a URL está correta

    // Preenche o formulário de registro
    cy.get('input[name="name"]').type('Test User'); // Insira um nome
    cy.get('input[name="email"]').type('test@example.com'); // Insira um email válido
    cy.get('input[name="password"]').type('password'); // Insira a senha
    cy.get('input[name="password_confirmation"]').type('password'); // Confirma a senha
    cy.get('button[type="submit"]').click(); // Clica no botão de cadastro

    // Verifica se o redirecionamento foi para a página inicial
    cy.url().should('include', 'http://localhost:8000'); 
  });
  
  it('should load the cart page when authenticated', () => {
    // Simula o login do usuário
    cy.visit('http://localhost:8000/login');
    cy.get('input[name="email"]').type('test@example.com'); // Insira um email válido
    cy.get('input[name="password"]').type('password'); // Insira a senha
    cy.get('button[type="submit"]').click(); // Clica no botão de login
    cy.url().should('include', 'http://localhost:8000'); // Verifica se o redirecionamento foi para a página inicial

    
  });

  // Teste de usabilidade adicional para verificar elementos interativos
  it('should allow user to add items to the cart', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // Clica no botão de adicionar ao carrinho no primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); // Acessa o carrinho
    cy.get('tbody > tr > :nth-child(1)').should('have.length', 1); // Verifica se o item foi adicionado ao carrinho
  });
  
  it('should allow user to decrease item quantity in the cart', () => {
    // Adiciona um item ao carrinho
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // Clica no botão de adicionar ao carrinho no primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); // Acessa o carrinho

    // Aumenta a quantidade do item para 2
    cy.get('.mais').click(); // Clica no botão para aumentar a quantidade
    cy.get('.mais').click(); // Clica novamente para aumentar a quantidade para 3

    // Diminui a quantidade do item
    cy.get('.menos').click(); // Clica no botão para diminuir a quantidade (ajuste o seletor conforme necessário)
    cy.get('tbody > tr').find('td').eq(1).should('contain.text', '2');  // Verifica se a quantidade foi atualizada para 2 (ajuste o seletor conforme necessário)
  });

  it('should allow user to remove item from the cart', () => {
    // Adiciona um item ao carrinho
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.get('.cardapio > .p').first().find('button.add').contains('Adicionar ao Carrinho').click(); // Clica no botão de adicionar ao carrinho no primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); // Acessa o carrinho

    // Remove o item do carrinho
    cy.get('.remover').click(); // Clica no botão para remover o item (ajuste o seletor conforme necessário)
    cy.get('tbody > tr').should('have.length', 0); // Verifica se o carrinho está vazio
  });


  it('should complete the purchase', () => {
    

    cy.get('a[href="http://localhost:8000"]').click();
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // Clica no botão de adicionar ao carrinho no primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); // Acessa o carrinho
    cy.get('tbody > tr > :nth-child(1)').should('have.length', 1); // Verifica se o item foi adicionado ao carrinho
    cy.get('.final-carrinho > a').click(); // Acessa a página de checkout

    // Simula o login do usuário
    cy.visit('http://localhost:8000/login');
    cy.get('input[name="email"]').type('test@example.com'); // Insira um email válido
    cy.get('input[name="password"]').type('password'); // Insira a senha
    cy.get('button[type="submit"]').click(); // Clica no botão de login
    cy.url().should('include', 'http://localhost:8000/cart/checkout'); // Verifica se o redirecionamento foi para a página inicial

    // Preenche o formulário de checkout
    cy.get('input[name="rua"]').type('Avenida das Flores'); // Insira a rua
    cy.get('input[name="numero"]').type('123'); // Insira o número
    cy.get('input[name="cep"]').type('12345678'); // Insira o CEP
    cy.get('input[name="cidade"]').type('Cidade Exemplo'); 
        // Preenche o formulário de checkout
        cy.get('input[name="rua"]').type('Avenida das Flores'); // Insira a rua
        cy.get('input[name="numero"]').type('123'); // Insira o número
        cy.get('input[name="cep"]').type('12345678'); // Insira o CEP
        cy.get('input[name="cidade"]').type('Cidade Exemplo'); // Insira a cidade
        cy.get('input[name="complemento"]').type('Apto 45'); // Insira um complemento (opcional)
        
        // Seleciona a forma de pagamento
        cy.get('select[name="forma_pagamento"]').select('cartao'); // Seleciona "Cartão de Crédito"
        
        // Clica no botão para finalizar a compra
        cy.get('button.button-final').click(); // Clica no botão "Finalizar Compra"
        
        // Verifica se o redirecionamento foi para a página de pedidos
        cy.url().should('include', 'http://localhost:8000/pedidos'); 
        cy.get('h1').should('contain', 'Minhas Compras'); // Verifica se a página contém o título correto
      });


});
