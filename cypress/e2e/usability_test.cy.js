describe('Usability Tests for PadariaV Laravel', () => {
  
  beforeEach(() => {
    cy.visit('http://localhost:8000'); // página inicial
  });

  it('should load the menu page correctly', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // página de cardápio
    cy.url().should('include', 'http://localhost:8000'); // URL correta
    cy.get('h1').should('contain', 'Cardápio'); // título correto
  });

  it('should register a user', () => {
    cy.get('a[href="http://localhost:8000/register"]').click(); // página de cadastro
    cy.url().should('include', 'http://localhost:8000/register'); // URL correta

    // Preenche o formulário de registro
    cy.get('input[name="name"]').type('Test User'); 
    cy.get('input[name="email"]').type('test@hotmail.com'); 
    cy.get('input[name="password"]').type('password'); 
    cy.get('input[name="password_confirmation"]').type('password'); 
    cy.get('button[type="submit"]').click(); 

    //página inicial
    cy.url().should('include', 'http://localhost:8000'); 
  });
  
  it('should load the cart page when authenticated', () => {
    // login do usuário
    cy.visit('http://localhost:8000/login');
    cy.get('input[name="email"]').type('test@hotmail.com'); 
    cy.get('input[name="password"]').type('password'); 
    cy.get('button[type="submit"]').click(); 
    cy.url().should('include', 'http://localhost:8000'); //página inicial

    
  });

  it('should allow user to add items to the cart', () => {
    cy.get('a[href="http://localhost:8000"]').click(); // cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // adicionar ao carrinho - primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); 
    cy.get('tbody > tr > :nth-child(1)').should('have.length', 1); 
  });
  
  it('should allow user to decrease item quantity in the cart', () => {
    
    cy.get('a[href="http://localhost:8000"]').click(); // cardápio
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); // adicionar ao carrinho - primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); 

    // Aumenta a quantidade do item para 2 e então para 3
    cy.get('.mais').click(); 
    cy.get('.mais').click(); 

    // Diminui a quantidade do item
    cy.get('.menos').click(); 
    cy.get('tbody > tr').find('td').eq(1).should('contain.text', '2');  // Verifica se a quantidade foi atualizada para 2 
  });

  it('should allow user to remove item from the cart', () => {
    
    cy.get('a[href="http://localhost:8000"]').click(); // cardápio
    cy.get('.cardapio > .p').first().find('button.add').contains('Adicionar ao Carrinho').click(); //adicionar ao carrinho - primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); 

    // Remove o item do carrinho
    cy.get('.remover').click(); 
    cy.get('tbody > tr').should('have.length', 0); // Verifica se o carrinho está vazio
  });

  //caminho completo
  it('should complete the purchase', () => {    

    cy.get('a[href="http://localhost:8000"]').click();
    cy.get('.cardapio > :nth-child(1)').first().find('button.add').contains('Adicionar ao Carrinho').click(); //adicionar ao carrinho - primeiro item
    cy.get('a[href="http://localhost:8000/cart"]').click(); 
    cy.get('tbody > tr > :nth-child(1)').should('have.length', 1); 
    cy.get('.final-carrinho > a').click(); 

    // login do usuário
    cy.visit('http://localhost:8000/login');
    cy.get('input[name="email"]').type('test@hotmail.com'); 
    cy.get('input[name="password"]').type('password'); 
    cy.get('button[type="submit"]').click(); 
    cy.url().should('include', 'http://localhost:8000/cart/checkout'); 

    // Preenche o formulário de checkout
    cy.get('input[name="cep"]').type('01001-000').type('{enter}');    
    cy.get('input[name="numero"]').type('1028'); 
    cy.get('input[name="complemento"]').type('Apto 45'); 
    cy.get('select[name="forma_pagamento"]').select('cartao'); 
        
    cy.get('button.button-final').click(); 
        
    cy.url().should('include', 'http://localhost:8000/pedidos'); 
    cy.get('h1').should('contain', 'Minhas Compras'); 
  
  });


});
