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
    var writing_speed = properties.get('writing_speed');
} catch (err) {
    // alert("properties.fileが見つかりません。実行フォルダに配置してください。")
    // window.close();
    console.log(err.message);
}

fixture `Getting Started`.page `${login_url}`
    // .beforeEach(async t => {
    //     t.wait(1000)
    // });

test('Order test by Sakaki Seller', async t => {
    let today = new Date().toISOString().slice(0, 10)
    let order_item_selector = Selector('.order_item_list_table').find('tbody > tr');
    await t
        .maximizeWindow()
        // .wait(waiting_time)
        .typeText(user_identity, sakaki_user_name, { speed: writing_speed })
        // .wait(waiting_time)
        .typeText(password_identity, sakaki_password, { speed: writing_speed })
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
        //Details page navigate by first receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(0).find('td').nth(1).find('a')) //Tr value canbe changed
        .wait(waiting_time)
        .scrollBy(0, 300)
        // ========First row checkbox checked============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page again by breadcumb
        .click(Selector('h6').find('a').withText('受注トップ'))
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .scrollIntoView(Selector('.order_list_table'))
        .scrollIntoView(Selector('.orderDetailTable '))
        .click(Selector('.srchBtn').withText("検索"))
        // ========Details page navigate by 4th receive datetime============
        .click(Selector('.order_list_table').find('tbody > tr').nth(3).find('td').nth(1).find('a')) //Tr value canbe changed
        .wait(waiting_time)
        .scrollBy(0, 300)
        // ========Go to order item page from order details page by first trade number============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(4).find('a'))
        //correction delivery date change
        .typeText(Selector('.correction_delivery_date_table').find('tr').nth(0).find('td').nth(1).find('input[type=date]'), today)
        // Case, Bara and error change than save
        .typeText(order_item_selector.nth(0).find('td').nth(3).find('input[type=number]'), '1', { replace: true })
        .click(order_item_selector.nth(0).find('td').nth(11).find('.error_found'))
        .click(order_item_selector.nth(0).find('td').nth(11).find('.error_found').find('option').withText('納入者品切（取引先責）'))
        .typeText(order_item_selector.nth(1).find('td').nth(3).find('input[type=number]'), '2', { replace: true })
        .typeText(order_item_selector.nth(1).find('td').nth(5).find('input[type=number]'), '2', { replace: true })
        .click(order_item_selector.nth(1).find('td').nth(11).find('.error_found'))
        .click(order_item_selector.nth(1).find('td').nth(11).find('.error_found').find('option').withText('メーカー品切（取引先責）'))
        .click(Selector('.btn-primary').withText("更新"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order details page by breadcumb
        .click(Selector('h6').find('a').withText('受注伝票一覧'))
        // First row checkbox checked
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .click(Selector('.srchBtn').withText("検索"))
        // Go to order details page by click 2nd receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(1).find('td').nth(1).find('a'))
        // First row checkbox checked
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .click(Selector('.srchBtn').withText("検索"))
        // Go to order details page by click 3rd receive datetime   Video: 3.04 sec
        .click(Selector('.order_list_table').find('tbody > tr').nth(2).find('td').nth(1).find('a'))
        // ========First row checkbox checked============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .click(Selector('.srchBtn').withText("検索"))
        // Go to order details page by click 5th receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(4).find('td').nth(1).find('a'))
        // ========First row checkbox checked============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .click(Selector('.srchBtn').withText("検索"))
        // Go to order details page by click 6th receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(5).find('td').nth(1).find('a'))
        // ========Go to order item page from order details page by first trade number============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(4).find('a'))
        //correction delivery date change
        .typeText(Selector('.correction_delivery_date_table').find('tr').nth(0).find('td').nth(1).find('input[type=date]'), today)
        //correction delivery date Save
        .click(Selector('.btn-primary').withText("更新"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order details page by breadcumb
        .click(Selector('h6').find('a').withText('受注伝票一覧'))
        // ========First row checkbox checked============
        .click(Selector('.order_details_table').find('tbody > tr').nth(0).find('td').nth(1).find('input[type=checkbox]'))
        .click(Selector('.btn-primary').withText("選択行を伝票確定"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // Go to order details page by click 1st receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(0).find('td').nth(1).find('a'))
        // Order data send
        .click(Selector('.btn-danger').withText("確定データ送信"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // Go to order details page by click 2nd receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(1).find('td').nth(1).find('a'))
        // Order data send
        .click(Selector('.btn-danger').withText("確定データ送信"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // Go to order details page by click 3rd receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(2).find('td').nth(1).find('a'))
        // Order data send
        .click(Selector('.btn-danger').withText("確定データ送信"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // Go to order details page by click 4th receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(3).find('td').nth(1).find('a'))
        // Order data send
        .click(Selector('.btn-danger').withText("確定データ送信"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // Go to order details page by click 5th receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(4).find('td').nth(1).find('a'))
        // Order data send
        .click(Selector('.btn-danger').withText("確定データ送信"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // Go to order details page by click 6th receive datetime
        .click(Selector('.order_list_table').find('tbody > tr').nth(5).find('td').nth(1).find('a'))
        // Order data send
        .click(Selector('.btn-danger').withText("確定データ送信"))
        .click(Selector('.swal2-confirm').withText("はい"))
        .click(Selector('.swal2-confirm').withText("完了"))
        // Go to order list page
        .click(Selector('h6').find('a').withText('受注トップ'))
        // ========Partner Code modal to search============
        .click(Selector('.btn-primary').withText("参照"))
        .click(Selector('.order_list_partner_code_modal').find('tbody > tr').nth(0))
        .click(Selector('.srchBtn').withText("検索"))
        .scrollIntoView(Selector('.order_list_table'))

    // .click(logout_btn_identity)
    // .wait(waiting_time);
});