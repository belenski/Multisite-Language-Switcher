module.exports = {
  title: 'Multisite Language Switcher',
  description: 'Simple, powerful and easy to use',
  serviceWorker: true,
  head: [
    [ 'link', { rel: 'icon', href: '/images/icon-128x128.png' } ]
  ],
  ga: 'UA-1058133-32',
  themeConfig: {
    logo: '/images/icon-256x256.png',
    lastUpdated: 'Last Updated',
    repo: 'lloc/multisite-language-switcher',
    repoLabel: 'Github Repository',
    docsRepo: 'lloc/multisite-language-switcher',
    docsDir: 'docs',
    docsBranch: 'master',
    editLinks: true,
    editLinkText: 'Help me improve this page!',
    nav: [
      {
        text: 'Plugin Directory',
        link: 'https://wordpress.org/plugins/multisite-language-switcher/',
      },
      {
        text: 'API documentation',
        link: 'https://msls.co/api-documentation/',
      }
    ],
    sidebar: [
      ['/', 'Home'],
      {
        title: 'User documentation',
        children: [
          '/user-docs/',
          '/user-docs/install-multisite',
          '/user-docs/plugin-configuration',
          '/user-docs/editing-association-contents',
          '/user-docs/integration-website'
        ],
      },
      {
        title: 'Developer documentation',
        children: [
          '/developer-docs/snippets-examples',
          '/developer-docs/hook-reference'
        ],
      },
      {
        title: 'Appendices',
        children: [
          '/appendices/faq',
          '/appendices/help-donations',
          '/appendices/acknowledgment',
          '/appendices/license',
        ],
      },
    ]
  }
}
