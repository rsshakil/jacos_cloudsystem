import { Selector } from 'testcafe';
var PropertiesReader = require('properties-reader');
try {
    var properties = PropertiesReader('tests/Testcafe/properties/login.file');
    // console.log(properties)
    var waiting_time = properties.get('waiting_time');
    var super_user_name = properties.get('super_user_name');
    var sakaki_user_name = properties.get('sakaki_user_name');
    var slr_user_name = properties.get('slr_user_name');
    var byr_user_name = properties.get('byr_user_name');
    var password = properties.get('password');
    var sakaki_password = properties.get('sakaki_password');
    var login_url = properties.get('login_url');
    var user_identity = properties.get('user_identity');
    var password_identity = properties.get('password_identity');
    var login_btn_identity = properties.get('login_btn_identity');
    var logout_btn_identity = properties.get('logout_btn_identity');
} catch (err) {
    // alert("properties.fileが見つかりません。実行フォルダに配置してください。")
    // window.close();
    console.log(err.message);
}

fixture `Getting Started`.page `${login_url}`
    // .beforeEach(async t => {
    //     t.wait(1000)
    // });

test('Sakaki Seller Test', async t => {
    // const firstItem = Selector('.buyer_button_list:nth-child(2)');
    // console.log(Selector('ul'));
    const osCount = Selector('.jcs_left_side_bar_menu').count;
    // console.log(osCount)
    await t
        .maximizeWindow()
        // .wait(waiting_time)
        .typeText(user_identity, sakaki_user_name)
        // .wait(waiting_time)
        .typeText(password_identity, sakaki_password)
        // .wait(waiting_time)
        // .takeScreenshot({
        //     path:     'my-fixture/welcome_page.png',
        //     fullPage: true
        // })
        .click(login_btn_identity)
        // .wait(waiting_time)
        .click(Selector('.btn-outline-primary').nth(0))
        // .wait(waiting_time)
        .click(Selector('.jcs_left_side_bar_menu').nth(4).child(0))
        .wait(waiting_time)
        // .scrollIntoView(Selector('.order_item_details_table'), { offsetX: 1, offsetY: 1 })
        .scrollIntoView(Selector('.order_item_details_table'))
        .scrollIntoView(Selector('.orderDetailTable '))
        .wait(waiting_time)

    // .click(logout_btn_identity)
    // .wait(waiting_time);
});
// test('Seller Test', async t => {
//     await t
//         .wait(waiting_time)
//         .typeText(user_identity, slr_user_name)
//         .wait(waiting_time)
//         .typeText(password_identity, password)
//         .wait(waiting_time)
//         .click(login_btn_identity)
//         .wait(waiting_time)
//         .click(logout_btn_identity)
//         .wait(waiting_time);
// });
// test('Buyer Test', async t => {
//     await t
//         .wait(waiting_time)
//         .typeText(user_identity, byr_user_name)
//         .wait(waiting_time)
//         .typeText(password_identity, password)
//         .wait(waiting_time)
//         .click(login_btn_identity)
//         .wait(waiting_time)
//         .click(logout_btn_identity)
//         .wait(waiting_time);
// });