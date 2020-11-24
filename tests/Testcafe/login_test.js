import { Selector } from 'testcafe';

fixture `Getting Started`
    .page `http://localhost/jcs/login`
    // .beforeEach(async t => {
    //     t.wait(1000)
    // });

test('Super Admin Test', async t => {
    await t
        .maximizeWindow()
        .wait(1000)
        .typeText('#email', 'super_admin@jacos.co.jp')
        .wait(1000)
        .typeText('#password', 'Qe75ymSr')
        .wait(1000)
        // .takeScreenshot({
        //     path:     'my-fixture/welcome_page.png',
        //     fullPage: true
        // })
        .click('#login')
        .wait(3000)
        .click('.logout_btn')
        .wait(3000);
});
test('Seller Test', async t => {
    await t
        .wait(1000)
        .typeText('#email', 'slr01@test.jp')
        .wait(1000)
        .typeText('#password', 'Qe75ymSr')
        .wait(1000)
        .click('#login')
        .wait(3000)
        .click('.logout_btn')
        .wait(3000);
});
test('Buyer Test', async t => {
    await t
        .wait(1000)
        .typeText('#email', 'byr01@test.jp')
        .wait(1000)
        .typeText('#password', 'Qe75ymSr')
        .wait(1000)
        .click('#login')
        .wait(3000)
        .click('.logout_btn')
        .wait(3000);
});