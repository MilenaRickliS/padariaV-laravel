describe('Interface Tests for PadariaV Laravel', () => {
  
  beforeEach(() => {
    cy.visit('http://localhost:8000'); // Visita a página inicial antes de cada teste
  });

  it('should display the menu page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.url().should('include', 'http://localhost:8000'); // Verifica a URL
    cy.get('h1').should('contain', 'Cardápio'); // Verifica se o título está correto
    cy.get('.cardapio').should('be.visible'); // Verifica se a seção do cardápio está visível
    cy.get('.cardapio > :nth-child(1)').should('have.length.greaterThan', 0); // Verifica se há produtos no cardápio
  });

  it('should display the cart page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // Clica no botão de adicionar ao carrinho no primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); // Acessa o carrinho
    cy.url().should('include', '/cart'); // Verifica a URL
    cy.get('h1').should('contain', 'Carrinho de Compras'); // Verifica se o título está correto
    cy.get('.carrinho').should('be.visible'); // Verifica se a tabela do carrinho está visível
    cy.get('tbody > tr > :nth-child(1)').should('have.length', 1); // Verifica se o item foi adicionado ao carrinho
    
  });

  it('should display the login page correctly', () => {
    cy.get('a[href="http://localhost:8000/login"]').click(); // Acessa a página de login
    cy.url().should('include', '/login'); // Verifica a URL
    cy.get('div').should('contain', 'Login'); // Verifica se o título está correto
    cy.get('input[name="email"]').should('be.visible'); // Verifica se o campo de email está visível
    cy.get('input[name="password"]').should('be.visible'); // Verifica se o campo de senha está visível
    cy.get('button[type="submit"]').should('contain', 'Login'); // Verifica se o botão de login está visível
  });

  it('should display the registration page correctly', () => {
    cy.get('a[href="http://localhost:8000/register"]').click(); // Acessa a página de cadastro
    cy.url().should('include', '/register'); // Verifica a URL
    cy.get('div').should('contain', 'Register'); // Verifica se o título está correto
    cy.get('input[name="name"]').should('be.visible'); // Verifica se o campo de nome está visível
    cy.get('input[name="email"]').should('be.visible'); // Verifica se o campo de email está visível
    cy.get('input[name="password"]').should('be.visible'); // Verifica se o campo de senha está visível
    cy.get('button[type="submit"]').should('contain', 'Register'); // Verifica se o botão de cadastro está visível
  });

  it('should display the checkout page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // Clica no botão de adicionar ao carrinho no primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); // Acessa o carrinho
    cy.get('.final-carrinho > a').click(); // Acessa a página de checkout

    cy.get('input[name="email"]').type('test@example.com'); // Insira um email válido
    cy.get('input[name="password"]').type('password'); // Insira a senha
    cy.get('button[type="submit"]').click(); // Clica no botão de login

    cy.url().should('include', '/cart/checkout'); // Verifica a URL
    cy.get('h1').should('contain', 'Finalizar Compra'); // Verifica se o título está correto
    cy.get('input[name="rua"]').should('be.visible'); // Verifica se o campo de rua está visível
    cy.get('input[name="numero"]').should('be.visible'); // Verifica se o campo de número está visível
    cy.get('input[name="cep"]').should('be.visible'); // Verifica se o campo de CEP está visível
    cy.get('input[name="cidade"]').should('be.visible'); // Verifica se o campo de CEP está visível
    cy.get('input[name="complemento"]').should('be.visible'); // Verifica se o campo de CEP está visível
    cy.get('select[name="forma_pagamento"]').should('be.visible'); // Verifica se o campo de CEP está visível
    cy.get('button[type="submit"]').should('contain', 'Finalizar Compra'); // Verifica se o botão de finalizar compra está visível
  });

  it('should display the orders page correctly', () => {
    cy.get('a[href="http://localhost:8000/pedidos"]').click(); // Acessa a página de pedidos
    cy.get('input[name="email"]').type('test@example.com'); // Insira um email válido
    cy.get('input[name="password"]').type('password'); // Insira a senha
    cy.get('button[type="submit"]').click(); // Clica no botão de login
    cy.url().should('include', '/pedidos'); // Verifica a URL
    cy.get('h1').should('contain', 'Minhas Compras'); // Verifica se o título está correto
    cy.get('.pedidos').should('be.visible'); // Verifica se a seção de pedidos está visível
    cy.get('.pedido').should('have.length.greaterThan', 0); // Verifica se há pedidos listados
  });

  // Teste para verificar o fluxo completo: login, adicionar ao carrinho e finalizar compra
  it('should allow user to complete a purchase flow', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // Acessa a página de cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click();
    
    // Acessa o carrinho
    cy.get('a[href="http://localhost:8000/cart"]').click();
    cy.get('tbody > tr').should('have.length', 1); // Verifica se o item foi adicionado ao carrinho

    // Finaliza a compra
    cy.get('.final-carrinho > a').click();

    // Acessa a página de login
    cy.get('a[href="http://localhost:8000/login"]').click();
    cy.url().should('include', '/login');
    
    cy.get('input[name="email"]').type('test@example.com'); // Insira um email válido
    cy.get('input[name="password"]').type('password'); // Insira a senha
    cy.get('button[type="submit"]').click(); // Clica no botão de login
    
    cy.url().should('include', '/cart/checkout');
    cy.get('input[name="rua"]').type('Rua Exemplo');
    cy.get('input[name="numero"]').type('123');
    cy.get('input[name="cep"]').type('12345-678');
    cy.get('input[name="cidade"]').type('Cidade Exemplo'); // Insira a cidade
    cy.get('input[name="complemento"]').type('Apto 45'); // Insira um complemento (opcional)        
    // Seleciona a forma de pagamento
    cy.get('select[name="forma_pagamento"]').select('cartao'); // Seleciona "Cartão de Crédito"
    cy.get('button.button-final').click();

    // Verifica se a compra foi concluída
    cy.url().should('include', '/pedidos'); // Supondo que após a compra, o usuário é redirecionado para a página de pedidos
    cy.get('h1').should('contain', 'Minhas Compras');
    cy.get('.pedido').should('have.length.greaterThan', 0); // Verifica se há pelo menos um pedido na lista
  });
});