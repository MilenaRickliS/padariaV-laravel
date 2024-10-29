describe('Interface Tests for PadariaV Laravel', () => {
  
  beforeEach(() => {
    cy.visit('http://localhost:8000'); // página inicial 
  });

  it('should display the menu page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); 
    cy.url().should('include', 'http://localhost:8000'); // Verifica a URL
    cy.get('h1').should('contain', 'Cardápio'); // título correto
    cy.get('.cardapio').should('be.visible'); // seção visível
    cy.get('.cardapio > :nth-child(1)').should('have.length.greaterThan', 0); // produtos no cardápio
  });

  it('should display the cart page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); 
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // adicionar ao carrinho - primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); 
    cy.url().should('include', '/cart'); // Verifica a URL
    cy.get('h1').should('contain', 'Carrinho de Compras'); // título correto
    cy.get('.carrinho').should('be.visible'); // tabela do carrinho visível
    cy.get('tbody > tr > :nth-child(1)').should('have.length', 1); // item adicionado ao carrinho
    
  });

  it('should display the login page correctly', () => {
    cy.get('a[href="http://localhost:8000/login"]').click(); 
    cy.url().should('include', '/login'); // Verifica a URL
    cy.get('div').should('contain', 'Login'); // título correto
    cy.get('input[name="email"]').should('be.visible'); //campos visíveis
    cy.get('input[name="password"]').should('be.visible'); 
    cy.get('button[type="submit"]').should('contain', 'Login'); 
  });

  it('should display the registration page correctly', () => {
    cy.get('a[href="http://localhost:8000/register"]').click();
    cy.url().should('include', '/register'); // Verifica a URL
    cy.get('div').should('contain', 'Register'); //título correto
    cy.get('input[name="name"]').should('be.visible'); //campos visíveis
    cy.get('input[name="email"]').should('be.visible'); 
    cy.get('input[name="password"]').should('be.visible'); 
    cy.get('button[type="submit"]').should('contain', 'Register'); 
  });

  it('should display the checkout page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); 
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // adicionar ao carrinho - primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); 
    cy.get('.final-carrinho > a').click(); // página de checkout

    //login
    cy.get('input[name="email"]').type('test@example.com'); 
    cy.get('input[name="password"]').type('password'); 
    cy.get('button[type="submit"]').click(); 

    cy.url().should('include', '/cart/checkout'); // Verifica a URL
    cy.get('h1').should('contain', 'Finalizar Compra'); // título correto
    cy.get('input[name="rua"]').should('be.visible'); //campos visíveis
    cy.get('input[name="numero"]').should('be.visible'); 
    cy.get('input[name="cep"]').should('be.visible'); 
    cy.get('input[name="cidade"]').should('be.visible'); 
    cy.get('input[name="complemento"]').should('be.visible'); 
    cy.get('select[name="forma_pagamento"]').should('be.visible'); 
    cy.get('button[type="submit"]').should('contain', 'Finalizar Compra'); 
  });

  it('should display the orders page correctly', () => {
    cy.get('a[href="http://localhost:8000/pedidos"]').click(); 
    //login
    cy.get('input[name="email"]').type('test@example.com'); 
    cy.get('input[name="password"]').type('password'); 
    cy.get('button[type="submit"]').click(); 
    cy.get('a[href="http://localhost:8000/pedidos"]').click(); 
    

    cy.url().should('include', '/pedidos'); // Verifica a URL
    cy.get('h1').should('contain', 'Minhas Compras'); // título correto
    cy.get('.pedidos').should('be.visible'); // seção visível
    cy.get('.pedido').should('have.length.greaterThan', 0); 
  });

  // fluxo completo
  it('should allow user to complete a purchase flow', () => {
    cy.get('a[href="http://localhost:8000"]').click(); 
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click();
    
    // Acessa o carrinho
    cy.get('a[href="http://localhost:8000/cart"]').click();
    cy.get('tbody > tr').should('have.length', 1); 

    // Finaliza a compra
    cy.get('.final-carrinho > a').click();

    // login
    cy.get('a[href="http://localhost:8000/login"]').click();
    cy.url().should('include', '/login');
    
    cy.get('input[name="email"]').type('test@example.com'); 
    cy.get('input[name="password"]').type('password'); 
    cy.get('button[type="submit"]').click(); 
    
    //checkout
    cy.url().should('include', '/cart/checkout');
    cy.get('input[name="rua"]').type('Rua Exemplo');
    cy.get('input[name="numero"]').type('123');
    cy.get('input[name="cep"]').type('12345-678');
    cy.get('input[name="cidade"]').type('Cidade Exemplo'); 
    cy.get('input[name="complemento"]').type('Apto 45');        
    cy.get('select[name="forma_pagamento"]').select('cartao'); 
    cy.get('button.button-final').click();

    //pedidos
    cy.url().should('include', '/pedidos'); 
    cy.get('h1').should('contain', 'Minhas Compras');
    cy.get('.pedido').should('have.length.greaterThan', 0); 
  });
});