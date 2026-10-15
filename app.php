<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ./login.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Кредитный документооборот: Автозаполнение</title>
  <link rel="stylesheet" href="./css/style.css">
  <script src="./js/main.js" defer></script>
</head>

<body>
  <div class="app-wrapper">
    <header class="app-header">
      <div class="logo-area">
        <div class="logo-icon">
        </div>
        <div class="logo-text">
          <h1>Кредитный документооборот</h1>
          <p>Автоматическое заполнение документов</p>
        </div>
      </div>
      <div class="header-actions">
        <button type="button" class="btn btn-outline" id="btn-clear-top">Очистить форму</button>
        <button type="button" class="btn btn-primary" id="btn-fill-top">Заполнить документы</button>
        <a href="./index.php" class="btn btn-text"><span class="icon-logout"></span> На главную</a>
        <a href="./auth/logout.php" class="btn btn-text"><span class="icon-logout"></span> Выход</a>

      </div>
    </header>

    <main class="app-main">
      <section class="form-section">
        <h2 class="section-title">2. Ввод данных заемщика</h2>

        <nav class="tabs-nav" id="tabs-nav">
          <button type="button" class="tab-btn active" data-target="tab-personal">Личные данные</button>
          <button type="button" class="tab-btn" data-target="tab-passport">Паспорт и адрес</button>
          <button type="button" class="tab-btn" data-target="tab-inn-snils">ИНН / СНИЛС</button>
          <button type="button" class="tab-btn" data-target="tab-work">Работа и доходы</button>
          <button type="button" class="tab-btn" data-target="tab-credit">Кредитные параметры</button>
          <button type="button" class="tab-btn" data-target="tab-collateral">Обеспечение и поручители</button>
          <button type="button" class="tab-btn" data-target="tab-bank">Банк</button>
        </nav>

        <form id="credit-form" autocomplete="off">

          <div id="tab-personal" class="tab-content active">
            <div class="form-row columns-4">
              <div class="form-group">
                <label for="last-name">Фамилия</label>
                <input type="text" id="last-name" name="lastName" placeholder="Введите фамилию">
              </div>
              <div class="form-group">
                <label for="first-name">Имя</label>
                <input type="text" id="first-name" name="firstName" placeholder="Введите имя">
              </div>
              <div class="form-group">
                <label for="middle-name">Отчество</label>
                <input type="text" id="middle-name" name="middleName" placeholder="Введите отчество">
              </div>
              <div class="form-group">
                <label for="birth-date">Дата рождения</label>
                <input type="date" id="birth-date" name="birthDate">
              </div>
            </div>
            <div class="form-row columns-3">
              <div class="form-group">
                <label for="birth-place">Место рождения</label>
                <input type="text" id="birth-place" name="birthPlace" placeholder="Введите место рождения">
              </div>
              <div class="form-group">
                <label for="citizenship">Гражданство</label>
                <input type="text" id="citizenship" name="citizenship" placeholder="Введите гражданство">
              </div>
              <div class="form-group">
                <label for="marital-status">Семейное положение</label>
                <select id="marital-status" name="maritalStatus">
                  <option value="" disabled selected>Выберите</option>
                  <option value="single">Холост / Не замужем</option>
                  <option value="married">Женат / Замужем</option>
                  <option value="divorced">В разводе</option>
                  <option value="widowed">Вдовец / Вдова</option>
                </select>
              </div>
            </div>
          </div>

          <div id="tab-passport" class="tab-content hidden">
            <h3 class="subsection-title">Паспортные данные</h3>
            <div class="form-row columns-4">
              <div class="form-group">
                <label for="doc-type">Вид документа</label>
                <input type="text" id="doc-type" name="docType">
              </div>
              <div class="form-group">
                <label for="passport-series">Серия</label>
                <input type="text" id="passport-series" name="passportSeries" placeholder="0000" maxlength="4">
              </div>
              <div class="form-group">
                <label for="passport-number">Номер</label>
                <input type="text" id="passport-number" name="passportNumber" placeholder="000000" maxlength="6">
              </div>
              <div class="form-group">
                <label for="issue-date">Дата выдачи</label>
                <input type="date" id="issue-date" name="issueDate">
              </div>
            </div>
            <div class="form-row columns-2">
              <div class="form-group">
                <label for="issued-by">Кем выдан</label>
                <input type="text" id="issued-by" name="issuedBy" placeholder="Наименование органа">
              </div>
              <div class="form-group">
                <label for="dept-code">Код подразделения</label>
                <input type="text" id="dept-code" name="deptCode" placeholder="000-000">
              </div>
            </div>

            <h3 class="subsection-title">Контактная информация</h3>
            <div class="form-row columns-2">
              <div class="form-group">
                <label for="reg-address">Адрес регистрации</label>
                <textarea id="reg-address" name="regAddress" rows="2" placeholder="Введите адрес регистрации"></textarea>
              </div>
              <div class="form-group">
                <label for="fact-address">Фактический адрес</label>
                <textarea id="fact-address" name="factAddress" rows="2" placeholder="Введите фактический адрес"></textarea>
              </div>
            </div>
            <div class="form-row columns-2">
              <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__">
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="example@mail.ru">
              </div>
            </div>
          </div>

          <div id="tab-inn-snils" class="tab-content hidden">
            <div class="form-row columns-3">
              <div class="form-group">
                <label for="inn">ИНН</label>
                <input type="text" id="inn" name="inn" placeholder="12 цифр" maxlength="12">
              </div>
              <div class="form-group">
                <label for="snils">СНИЛС</label>
                <input type="text" id="snils" name="snils" placeholder="000-000-000 00">
              </div>
              <div class="form-group">
                <label for="client-password">Пароль клиента (опционально)</label>
                <input type="text" id="client-password" name="clientPassword" placeholder="Кодовое слово">
              </div>
            </div>
          </div>

          <div id="tab-work" class="tab-content hidden">
            <h3 class="subsection-title">Сведения о работе</h3>
            <div class="form-row columns-4">
              <div class="form-group">
                <label for="workplace">Место работы</label>
                <input type="text" id="workplace" name="workplace" placeholder="ООО Ромашка">
              </div>
              <div class="form-group">
                <label for="position">Должность</label>
                <input type="text" id="position" name="position" placeholder="Менеджер">
              </div>
              <div class="form-group">
                <label for="industry">Сфера деятельности</label>
                <input type="text" id="industry" name="industry" placeholder="Торговля">
              </div>
              <div class="form-group">
                <label for="qualification">Квалификация</label>
                <input type="text" id="qualification" name="qualification" placeholder="Специалист">
              </div>
            </div>
            <h3 class="subsection-title">Финансы</h3>
            <div class="form-row columns-3">
              <div class="form-group">
                <label for="salary">Зарплата (руб.)</label>
                <input type="number" id="salary" name="salary" placeholder="0">
              </div>
              <div class="form-group">
                <label for="other-income">Прочие доходы (руб.)</label>
                <input type="number" id="other-income" name="otherIncome" placeholder="0">
              </div>
              <div class="form-group">
                <label for="obligatory-payments">Обязательные платежи (руб.)</label>
                <input type="number" id="obligatory-payments" name="obligatoryPayments" placeholder="0">
              </div>
            </div>
          </div>

          <div id="tab-credit" class="tab-content hidden">

            <h3 class="subsection-title">Кредитные параметры</h3>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="credit-purpose">Цель кредита</label>
                <input type="text" id="credit-purpose" name="creditPurpose">
              </div>

              <div class="form-group">
                <label for="credit-amount">Сумма кредита</label>
                <input type="number" id="credit-amount" name="creditAmount">
              </div>

              <div class="form-group">
                <label for="credit-currency">Валюта кредита</label>
                <input type="text" id="credit-currency" name="creditCurrency">
              </div>
            </div>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="credit-term">Срок (месяцы)</label>
                <input type="number" id="credit-term" name="creditTerm">
              </div>

              <div class="form-group">
                <label for="interest-rate">Процентная ставка (%)</label>
                <input type="number" step="0.01" id="interest-rate" name="interestRate">
              </div>

              <div class="form-group">
                <label for="psc-percent">Полная стоимость кредита (%)</label>
                <input type="number" step="0.01" id="psc-percent" name="pscPercent">
              </div>
            </div>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="psc-rub">Полная стоимость кредита (руб.)</label>
                <input type="number" id="psc-rub" name="pscRub">
              </div>

              <div class="form-group">
                <label for="overpayment">Переплата (руб.)</label>
                <input type="number" id="overpayment" name="overpayment">
              </div>

              <div class="form-group">
                <label for="penalty">Неустойка (%)</label>
                <input type="number" step="0.01" id="penalty" name="penalty">
              </div>
            </div>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="goods-category">Категория товаров/услуг</label>
                <input type="text" id="goods-category" name="goodsCategory">
              </div>

              <div class="form-group">
                <label for="goods-cost">Общая стоимость товаров/услуг</label>
                <input type="number" id="goods-cost" name="goodsCost">
              </div>

              <div class="form-group">
                <label for="down-payment">Первоначальный взнос (руб.)</label>
                <input type="number" id="down-payment" name="downPayment">
              </div>
            </div>

          </div>

          <div id="tab-collateral" class="tab-content hidden">

            <h3 class="subsection-title">Обеспечение</h3>

            <div class="form-row columns-2">
              <div class="form-group">
                <label for="collateral-subject">Предмет залога</label>
                <input type="text" id="collateral-subject" name="collateralSubject">
              </div>

              <div class="form-group">
                <label for="collateral-location">Местонахождение залога</label>
                <input type="text" id="collateral-location" name="collateralLocation">
              </div>
            </div>

            <div class="form-row columns-2">
              <div class="form-group">
                <label for="storage-place">Место хранения</label>
                <input type="text" id="storage-place" name="storagePlace">
              </div>

              <div class="form-group">
                <label for="collateral-owner">Владелец залога</label>
                <input type="text" id="collateral-owner" name="collateralOwner">
              </div>
            </div>

            <h3 class="subsection-title">Поручитель</h3>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="guarantor-fio">ФИО поручителя</label>
                <input type="text" id="guarantor-fio" name="guarantorFio">
              </div>

              <div class="form-group">
                <label for="guarantor-age">Возраст</label>
                <input type="number" id="guarantor-age" name="guarantorAge">
              </div>

              <div class="form-group">
                <label for="guarantor-income">Доход</label>
                <input type="number" id="guarantor-income" name="guarantorIncome">
              </div>
            </div>

            <div class="form-row columns-2">
              <div class="form-group">
                <label for="guarantor-address">Место жительства</label>
                <textarea id="guarantor-address" name="guarantorAddress"></textarea>
              </div>

              <div class="form-group">
                <label for="guarantor-work">Место работы</label>
                <input type="text" id="guarantor-work" name="guarantorWork">
              </div>
            </div>

            <h3 class="subsection-title">Кредитная история</h3>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="has-loans">Наличие предыдущих кредитов</label>
                <select id="has-loans" name="hasLoans">
                  <option value="">Выберите</option>
                  <option value="Да">Да</option>
                  <option value="Нет">Нет</option>
                </select>
              </div>

              <div class="form-group">
                <label for="bki-name">Наименование БКИ</label>
                <input type="text" id="bki-name" name="bkiName">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="loan-details">Детали предыдущих кредитов</label>
                <textarea id="loan-details" name="loanDetails"></textarea>
              </div>
            </div>

            <h3 class="subsection-title">Имущество</h3>

            <div class="form-row">
              <div class="form-group">
                <label for="property-list">Перечень собственности</label>
                <textarea id="property-list" name="propertyList"></textarea>
              </div>
            </div>

          </div>

          <div id="tab-bank" class="tab-content hidden">

            <h3 class="subsection-title">Банковские реквизиты</h3>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="bank-name">Наименование банка</label>
                <input type="text" id="bank-name" name="bankName">
              </div>

              <div class="form-group">
                <label for="bank-inn">ИНН банка</label>
                <input type="text" id="bank-inn" name="bankInn">
              </div>

              <div class="form-group">
                <label for="bank-bik">БИК</label>
                <input type="text" id="bank-bik" name="bankBik">
              </div>
            </div>

            <div class="form-row columns-2">
              <div class="form-group">
                <label for="bank-location">Место нахождения</label>
                <input type="text" id="bank-location" name="bankLocation">
              </div>

              <div class="form-group">
                <label for="bank-ks">Корреспондентский счёт</label>
                <input type="text" id="bank-ks" name="bankKs">
              </div>
            </div>

            <div class="form-row columns-3">
              <div class="form-group">
                <label for="client-account">Номер счёта клиента</label>
                <input type="text" id="client-account" name="clientAccount">
              </div>

              <div class="form-group">
                <label for="employee-position">Должность сотрудника банка</label>
                <input type="text" id="employee-position" name="employeePosition">
              </div>

              <div class="form-group">
                <label for="employee-fio">ФИО сотрудника банка</label>
                <input type="text" id="employee-fio" name="employeeFio">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="authority-basis">Основание</label>
                <select id="authority-basis" name="authorityBasis">
                  <option value="">Выберите</option>
                  <option value="Устав">Устав</option>
                  <option value="Доверенность">Доверенность</option>
                </select>
              </div>
            </div>

          </div>

        </form>

        <div class="info-panels-wrapper">
          <div class="info-panel check-panel">
            <h3>Проверка данных</h3>
            <ul class="check-list">
              <li class="check-item"><span class="icon-check"></span> Все обязательные поля заполнены</li>
              <li class="check-item"><span class="icon-check"></span> Формат ИНН: 12 цифр</li>
              <li class="check-item"><span class="icon-check"></span> Формат СНИЛС: xxx-xxx-xxx xx</li>
              <li class="check-item"><span class="icon-check"></span> Код подразделения: xxx-xxx</li>
              <li class="check-item"><span class="icon-check"></span> Сумма кредита: положительное число</li>
              <li class="check-item"><span class="icon-check"></span> Процентная ставка: от 0 до 100</li>
              <li class="check-item"><span class="icon-check"></span> Срок кредита: от 1 до 360 месяцев</li>
            </ul>
          </div>
          <div class="info-panel messages-panel">
            <h3>Сообщения</h3>
            <div class="message-box info">
              <span class="icon-info"></span> Ошибки и предупреждения будут отображаться здесь.
            </div>
          </div>
        </div>

        <div class="action-banner">
          <div class="action-banner-text">
            <div class="icon-document-ready"></div>
            <div>
              <h3>Готовы заполнить документы?</h3>
              <p>После нажатия кнопки система проверит данные, заполнит все документы и сформирует готовые файлы для скачивания.</p>
            </div>
          </div>
          <button type="button" class="btn btn-success btn-large" id="btn-fill-bottom">
            <span class="icon-file-export"></span> Заполнить документы
          </button>
        </div>

      </section>
    </main>

    <footer class="app-footer">
      <div class="footer-left">
        <span>Кредитный документооборот</span>
        <span class="footer-sub">Автоматическое заполнение кредитных документов</span>
        <span class="footer-copy">© 2024 Все права защищены</span>
      </div>
      <div class="footer-right">
        <a href="#" class="footer-link"><span class="icon-manual"></span> Инструкция</a>
        <a href="#" class="footer-link"><span class="icon-support"></span> Техническая поддержка</a>
      </div>
    </footer>
  </div>
</body>

</html>