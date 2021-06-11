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
    let today = new Date().toISOString().slice(0, 10)
    await t
        .maximizeWindow()
        // .wait(waiting_time)
        .typeText(user_identity, sakaki_user_name, { speed: 0.5 })
        // .wait(waiting_time)
        .typeText(password_identity, sakaki_password, { speed: 0.5 })
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
        // .wait(waiting_time)
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .scrollIntoView(Selector('.order_list_table'))
        .scrollIntoView(Selector('.orderDetailTable '))
        .click(Selector('.srchBtn').withText("検索"))
        // .click(Selector('.order_list_table').find('tbody > tr').nth(0).find('td').nth(1).find('a')) //Tr value canbe changed
        // .wait(waiting_time)
        // .scrollBy(0, 300)
        // ========Partner Code modal to search============
        // .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        // .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        // .click(Selector('.swal2-confirm').withText("はい"))
        // .click(Selector('.swal2-confirm').withText("完了"))
        // .click(Selector('h6').find('a').withAttribute('href', '/jcs/order_list'))
        // ========Partner Code modal to search============
        // .click(Selector('.btn-primary').withText("参照"))
        // .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        // .scrollIntoView(Selector('.order_list_table'))
        // .scrollIntoView(Selector('.orderDetailTable '))
        // .click(Selector('.srchBtn').withText("検索"))
        .click(Selector('.order_list_table').find('tbody > tr').nth(3).find('td').nth(1).find('a')) //Tr value canbe changed
        .wait(waiting_time)
        .scrollBy(0, 300)
        // ========Partner Code modal to search============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(4).find('a'))
        // .drag(Selector('.correction_delivery_date_table').find('tr').nth(0).find('td').nth(1).find('input[type=date]'), 360, 0, { offsetX: 350, offsetY: 10 })
        // .click(Selector('.correction_delivery_date_table').find('tr').nth(0).find('td').nth(1).find('input[type=date]'))
        // .click(Selector('.correction_delivery_date_table').find('tr').nth(0).find('td').nth(1).find('input[type=date]'), { offsetX: 800, offsetY: 10 })
        .typeText(Selector('.correction_delivery_date_table').find('tr').nth(0).find('td').nth(1).find('input[type=date]'), today)
        // .drag('.ui-slider-handle', 360, 0, { offsetX: 10, offsetY: 10 })
        .click(Selector('.order_item_list_table').find('tbody > tr').nth(0).find('td').nth(3).find('input[type=number]'))
        .pressKey('pagedown')
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