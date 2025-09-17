import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'

export function middleware(request: NextRequest) {
  const response = NextResponse.next()
  
  // Configurações de cache baseadas no tipo de arquivo/rota
  const { pathname } = request.nextUrl
  
  // Cache para assets estáticos
  if (pathname.match(/\.(ico|png|jpg|jpeg|gif|svg|webp|avif)$/)) {
    response.headers.set(
      'Cache-Control',
      'public, max-age=31536000, immutable'
    )
  }
  
  // Cache para fontes
  if (pathname.match(/\.(woff|woff2|eot|ttf|otf)$/)) {
    response.headers.set(
      'Cache-Control',
      'public, max-age=31536000, immutable'
    )
  }
  
  // Cache para vídeos
  if (pathname.match(/\.(mp4|webm|ogg|avi|mov)$/)) {
    response.headers.set(
      'Cache-Control',
      'public, max-age=31536000, immutable'
    )
  }
  
  // Cache para documentos PDF
  if (pathname.match(/\.pdf$/)) {
    response.headers.set(
      'Cache-Control',
      'public, max-age=31536000, immutable'
    )
  }
  
  // Cache para páginas estáticas (SSG)
  if (!pathname.startsWith('/api') && !pathname.startsWith('/_next')) {
    response.headers.set(
      'Cache-Control',
      'public, s-maxage=86400, stale-while-revalidate=604800'
    )
  }
  
  // Headers de segurança e performance
  response.headers.set('X-DNS-Prefetch-Control', 'on')
  response.headers.set('X-Frame-Options', 'DENY')
  response.headers.set('X-Content-Type-Options', 'nosniff')
  response.headers.set('Referrer-Policy', 'origin-when-cross-origin')
  
  // Preload de recursos críticos para a página inicial
  if (pathname === '/') {
    response.headers.set(
      'Link',
      '</fonts/Raleway/Raleway-Regular.ttf>; rel=preload; as=font; type=font/ttf; crossorigin, </fonts/Raleway/Raleway-Bold.ttf>; rel=preload; as=font; type=font/ttf; crossorigin'
    )
  }
  
  return response
}

// Configurar quais rotas o middleware deve processar
export const config = {
  matcher: [
    /*
     * Match all request paths except for the ones starting with:
     * - api (API routes)
     * - _next/static (static files)
     * - _next/image (image optimization files)
     * - favicon.ico (favicon file)
     */
    '/((?!api|_next/static|_next/image|favicon.ico).*)',
  ],
}